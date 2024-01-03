<?php

namespace Modules\Purchases\Http\Controllers;

use App\Helpers\NumberLetter;
use App\Models\District;
use App\Models\Kardex;
use App\Models\KardexSize;
use App\Models\PaymentMethod;
use App\Models\SaleDocumentType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Purchases\Entities\PurcDocument;
use App\Models\Parameter;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Purchases\Entities\PurcDocumentItems;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PurcDocumentController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $ubl;
    private $igv;
    private $top;
    private $icbper;

    public function __construct()
    {
        $this->ubl = Parameter::where('parameter_code', 'P000003')->value('value_default');
        $this->igv = Parameter::where('parameter_code', 'P000001')->value('value_default');
        $this->top = Parameter::where('parameter_code', 'P000002')->value('value_default');
        $this->icbper = Parameter::where('parameter_code', 'P000004')->value('value_default');
    }

    public function index()
    {

        $documents = (new PurcDocument())->newQuery();
        if (request()->has('search') && request()->input('search')) {
            $documents->whereDate('date_of_issue', '=', request()->input('search'));
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $documents->orderBy($attribute, $sort_order);
        } else {
            $documents->latest();
        }
        $documents = $documents->with('type');
        $documents = $documents->with('provider');
        $documents = $documents->paginate(10)->onEachSide(2);

        return Inertia::render('Purchases::Documents/List', [
            'documents' => $documents,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $saleDocumentTypes = SaleDocumentType::all();
        $payments = PaymentMethod::all();
        $documentTypes = DB::table('identity_document_type')->get();
        $unitTypes = DB::table('sunat_unit_types')->get();
        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();

        return Inertia::render('Purchases::Documents/Create', [
            'documentTypes'     => $documentTypes,
            'payments'          => $payments,
            'saleDocumentTypes' => $saleDocumentTypes,
            'unitTypes'         => $unitTypes,
            'type_operation'    => $this->top,
            'ubigeo'            => $ubigeo,
            'taxes'             => array(
                'igv' => $this->igv,
                'icbper' => $this->icbper
            )
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        ///se validan los campos requeridos
        $this->validate(
            $request,
            [
                'serie' => 'required',
                'date_issue' => 'required',
                'date_end' => 'required',
                'sale_documenttype_id' => 'required',
                'total' => 'required|numeric|min:0|not_in:0',
                'payments.*.type' => 'required',
                'payments.*.amount' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'items.*.quantity' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'items.*.unit_price' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'items.*.total' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'supplier_id' => 'required',
            ],
            [
                'items.*.quantity.required' => 'Ingrese Cantidad',
                'items.*.unit_price.required' => 'Ingrese precio',
                'items.*.unit_price.numeric' => 'Solo Numeros',
                'items.*.quantity.numeric' => 'Solo Numeros',
                'items.*.total.required' => 'Ingrese total',
            ]
        );

        try {
            $res = DB::transaction(function () use ($request) {

                ///si no existe una caja abierta para el usuario logueado en la tienda donde inicio session
                ///se crea una caja para poder hacer la venta

                $local_id = Auth::user()->local_id;
                $numberletters = new NumberLetter();
                $tido = SaleDocumentType::find($request->get('sale_documenttype_id'));
                ///se crea la venta
                $purchase = PurcDocument::create([
                    'user_id'               => Auth::id(),
                    'provider_id'           => $request->get('supplier_id'),
                    'local_id'              => $local_id,
                    'serie'                 => $request->get('serie'),
                    'number'                => $request->get('number'),
                    'document_type_id'      => $request->get('sale_documenttype_id'),
                    'date_of_issue'         => $request->get('date_issue'),
                    'date_of_due'           => $request->get('date_end'),
                    'currency_type_id'      => 'PEN',
                    'descripction'          => $request->get('descripction'),
                    'total'                 => $request->get('total'),
                    'legends'               => $numberletters->convertToLetter($request->get('total'))
                ]);


                ///obtenemos los productos o servicios para insertar en los 
                ///detalles de la venta y el documento
                $products = $request->get('items');

                ///totales de la cabecera
                $mto_oper_taxed = 0;
                $mto_igv = 0;
                $total_icbper = 0;
                $porcentage_icbper = 0.20;
                $total_discount = 0;
                $total = 0;

                foreach ($products as $produc) {
                    /// ahora tenemos que saber si es un producto o servicio ya existente
                    /// o si sera creado para esta venta, verificaremos esto por el id del producto
                    /// si el id es nulo quiere decir que es un producto nuevo y procedemos a crearlo
                    $product_id = null;
                    $interne = null;
                    if ($produc['id']) {
                        $product_id = $produc['id'];
                        $interne = $produc['interne'];
                        Product::find($product_id)->increment('stock', $produc['quantity']);
                    } else {
                        $length = 9; // Longitud del número aleatorio
                        $randomNumber = random_int(0, 999999999); // Genera un número aleatorio entre 0 y 999999999

                        $randomNumberPadded = str_pad($randomNumber, $length, '0', STR_PAD_LEFT);

                        $path = 'img/imagen-no-disponible.jpeg';

                        // creamos el nuevo producto o servicio
                        $new_product = Product::create([
                            'usine'                         => $randomNumberPadded,
                            'interne'                       => $randomNumberPadded,
                            'description'                   => $produc['description'],
                            'image'                         => $path,
                            'purchase_prices'               => $produc['unit_price'],
                            'sale_prices'                   => json_encode(array('high' => $produc['unit_price'], 'under' => null, 'medium' => null)),
                            'stock_min'                     => 1,
                            'stock'                         => $produc['quantity'],
                            'presentations'                 => false,
                            'is_product'                    => $produc['is_product'],
                            'type_sale_affectation_id'      => '10',
                            'type_purchase_affectation_id'  => '10',
                            'type_unit_measure_id'          => $produc['is_product'] ? $produc['unit_type'] : 'ZZ',
                            'status'                        => true
                        ]);
                        $product_id = $new_product->id;
                        $interne = $randomNumberPadded;
                        $item = $new_product;
                    }

                    /// imiciamos las variables para hacer los calculos por item;
                    $percentage_igv = $this->igv;
                    $mto_base_igv = 0;
                    $price_sale = $produc['unit_price'];
                    $nfactorIGV = round(($percentage_igv / 100) + 1, 2);
                    $ifactorIGV = round($percentage_igv / 100, 2);
                    $quantity = $produc['quantity'];
                    $value_unit = 0;
                    $igv = 0;
                    $total_tax = 0;
                    $icbper = 0;
                    $value_sale = 0;
                    $total_item = 0;
                    $mto_discount = 0;
                    $array_discounts = [];

                    if ($produc['afe_igv'] == '10') {
                        //valor unitario presio de venta / 1.IGV para quitarle el igv
                        //se tiene que quitar el igv porque el sistema trabaja con los precios
                        //incluido el igv
                        $value_unit = round($price_sale / $nfactorIGV, 2);
                        //la base para hacer el descuento 
                        $base = round($value_unit * $quantity, 2);
                        //el sistema resive un monto fijo como descuento y lo convierte a un porcentaje
                        $factor = (($produc['discount'] * 100) / $price_sale) / 100;
                        //el descuento se aplica por unidad vendida
                        $descuento_monto = $factor * $value_unit * $quantity;
                        //a la base igv le restamos el descuento
                        $mto_base_igv = ($value_unit * $quantity) - $descuento_monto;
                        //una ves restada la vase lo multiplicamos por el 18% vigente para sacar 
                        //el valor total igv
                        $igv = ($mto_base_igv * $ifactorIGV);
                        //total del item
                        $total_item = (($value_unit * $quantity) - $descuento_monto) + $igv;
                        //el valor de la venta
                        $value_sale = ($value_unit * $quantity) - $descuento_monto;
                        //si tiene descuento creamos el array de descuento
                        //2023-07-20 el sistema solo trabaja con un descuento
                        if ($produc['discount'] > 0) {
                            //el precio unitario se calcula
                            //(Valor venta + Total Impuestos) / Cantidad
                            $unit_price = round(($value_sale + $igv) / $quantity, 2);
                            $array_discounts[0] = array(
                                'value'     => $produc['discount'],
                                'type'      => '00',
                                'base'      => round($base, 2),
                                'factor'    => $factor,
                                'monto'     => round($descuento_monto, 2)
                            );
                        } else {
                            //el precio unitario es el mismo 
                            $unit_price = $price_sale;
                        }

                        $mto_discount = round($descuento_monto, 2);
                    }
                    if ($produc['afe_igv'] == '20') { //Exonerated

                    }
                    if ($produc['afe_igv'] == '30') { //Unaffected

                    }

                    if ($produc['icbper'] == 1) {
                        $porcentage_item_icbper = $porcentage_icbper;
                        $icbper = ($quantity * $porcentage_item_icbper);
                    } else {
                        $porcentage_item_icbper = 0;
                        $icbper = 0;
                    }
                    $total_tax = $igv + $icbper;

                    //se inserta los datos al detalle del documento 
                    PurcDocumentItems::create([
                        'purchase_id'               => $purchase->id,
                        'product_id'                => $product_id,
                        'date_of_due'               => Carbon::now()->format('Y-m-d'),
                        'affectation_igv_type_id'   => '10',
                        'price_type_id'             => '01',
                        'quantity'                  => $produc['quantity'],
                        'unit_value'                => $value_unit,
                        'total_base_igv'            => $mto_base_igv,
                        'percentage_igv'            => $this->igv,
                        'total_igv'                 => $igv,
                        'total_base_isc'            => 0,
                        'percentage_isc'            => 0,
                        'total_isc'                 => 0,
                        'total_base_other_taxes'    => 0,
                        'percentage_other_taxes'    => 0,
                        'total_other_taxes'         => 0,
                        'total_taxes'               => $total_tax,
                        'unit_price'                => $unit_price,
                        'total_value'               => $value_sale,
                        'total_charge'              => 0,
                        'total_discount'            => $mto_discount ?? 0,
                        'total'                     => round($total_item, 2),
                        'discounts'                 => json_encode($array_discounts),
                        'size'                      => $produc['size'] ?? null
                    ]);

                    if ($produc['is_product']) {
                        $k = Kardex::create([
                            'date_of_issue' => Carbon::now()->format('Y-m-d'),
                            'motion' => 'purchase',
                            'product_id' => $product_id,
                            'local_id' => $local_id,
                            'quantity' => $produc['quantity'],
                            'document_id' => $purchase->id,
                            'document_entity' => PurcDocument::class,
                            'description' => 'Compra'
                        ]);
                        $product = Product::find($product_id);
                        if ($product->presentations) {
                            KardexSize::create([
                                'kardex_id' => $k->id,
                                'product_id' => $produc['id'],
                                'local_id'  => $local_id,
                                'size'      => $produc['size'],
                                'quantity'  => $produc['quantity']
                            ]);

                            $tallas = $product->sizes;
                            $n_tallas = [];

                            foreach (json_decode($tallas, true) as $k => $talla) {
                                if ($talla['size'] == $produc['size']) {
                                    $n_tallas[$k] = array(
                                        'size' => $talla['size'],
                                        'quantity' => ($talla['quantity'] + $produc['quantity'])
                                    );
                                } else {
                                    $n_tallas[$k] = array(
                                        'size' => $talla['size'],
                                        'quantity' => $talla['quantity']
                                    );
                                }
                            }

                            $product->update([
                                'sizes' => json_encode($n_tallas)
                            ]);
                        }
                    }


                    $mto_igv = $mto_igv + $igv; //total del igv
                    $total_icbper = $total_icbper + $icbper; //total del impuesto a la bolsa plastica
                    $mto_oper_taxed = $mto_oper_taxed + $value_sale; // total operaciones gravadas
                    $total = $total + $total_item; // total de la venta general
                }
                //totales de la cabesera del documento
                $total_taxes = $mto_igv + $total_icbper;
                $subtotal = $total_taxes + $mto_oper_taxed;
                $ttotal = round($total, 1);
                $difference = abs($ttotal - $subtotal);
                $rounding = number_format($difference, 2);

                $purchase->update([
                    'total_prepayment'          => 0,
                    'total_charge'              => 0,
                    'total_discount'            => 0,
                    'total_exportation'         => 0,
                    'total_free'                => 0,
                    'total_taxed'               => $mto_oper_taxed,
                    'total_unaffected'          => 0,
                    'total_exonerated'          => 0,
                    'total_igv'                 => $mto_igv,
                    'total_base_isc'            => 0,
                    'total_isc'                 => 0,
                    'total_base_other_taxes'    => 0,
                    'total_other_taxes'         => 0,
                    'total_taxes'               => $total_taxes,
                    'total_value'               => $mto_oper_taxed,
                    'total_canceled'            => 0,
                ]);

                return $purchase;
            });

            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('purchases::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('purchases::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function anular($id)
    {
        try {
            $res = DB::transaction(function () use ($id) {

                $purchase = PurcDocument::find($id);
                $purchase->update([
                    'status' => 'A'
                ]);

                $products = PurcDocumentItems::where('purchase_id', $id)->get();

                foreach ($products as $produc) {

                    $pro = Product::find($produc->product_id);
                    $t = $pro->stock;

                    if ($pro->is_product) {
                        $k = Kardex::create([
                            'date_of_issue' => Carbon::now()->format('Y-m-d'),
                            'motion' => 'purchase',
                            'product_id' => $produc->product_id,
                            'local_id' => $purchase->local_id,
                            'quantity' => (-$produc->quantity),
                            'document_id' => $purchase->id,
                            'document_entity' => PurcDocument::class,
                            'description' => 'Compra Anulada'
                        ]);

                        if ($pro->presentations) {
                            KardexSize::create([
                                'kardex_id' => $k->id,
                                'product_id' => $produc->product_id,
                                'local_id' => $purchase->local_id,
                                'size'      => $produc['size'],
                                'quantity'  => (-$produc['quantity'])
                            ]);

                            $tallas = $pro->sizes;

                            $n_tallas = [];
                            foreach (json_decode($tallas, true) as $k => $talla) {
                                if ($talla['size'] == $produc['size']) {
                                    $n_tallas[$k] = array(
                                        'size' => $talla['size'],
                                        'quantity' => ($talla['quantity'] - $produc['quantity'])
                                    );
                                } else {
                                    $n_tallas[$k] = array(
                                        'size' => $talla['size'],
                                        'quantity' => $talla['quantity']
                                    );
                                }
                            }
                        }
                    }
                    $pro->update([
                        'stock' => $t - $produc->quantity,
                        'sizes' => json_encode($n_tallas)
                    ]);
                }


                return $purchase;
            });

            return response()->json([
                'success' => true,
                'message' => 'El Docuemtno fue anulado'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
