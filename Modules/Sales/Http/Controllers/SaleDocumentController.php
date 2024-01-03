<?php

namespace Modules\Sales\Http\Controllers;

use App\Helpers\Invoice\Documents\Boleta;
use App\Helpers\NumberLetter;
use App\Models\Company;
use App\Models\Department;
use App\Models\District;
use App\Models\Kardex;
use App\Models\KardexSize;
use App\Models\Parameter;
use App\Models\PaymentMethod;
use App\Models\Person;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDocument;
use App\Models\SaleDocumentItem;
use App\Models\SaleDocumentType;
use App\Models\SaleProduct;
use App\Models\Serie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Helpers\Invoice\Documents\Factura;

class SaleDocumentController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        $sales = (new Sale())->newQuery();

        $search = request()->input('search');

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $sales->orderBy($attribute, $sort_order);
        } else {
            $sales->latest();
        }

        $current_date = Carbon::now()->format('Y-m-d');

        $isAdmin = Auth::user()->hasRole('admin');
        $sales = $sales->join('people', 'client_id', 'people.id')
            ->join('sale_documents', 'sale_documents.sale_id', 'sales.id')
            ->join('series', 'sale_documents.serie_id', 'series.id')
            ->select(
                'sales.id',
                'sales.client_id',
                'sale_documents.id AS document_id',
                'people.full_name',
                'total',
                'advancement',
                'total_discount',
                'payments',
                'sales.created_at',
                'sales.local_id',
                'sale_documents.invoice_status',
                'sale_documents.invoice_response_description',
                'sale_documents.invoice_response_code',
                'sale_documents.invoice_notes',
                'sale_documents.status',
                'series.description AS serie',
                'sale_documents.number',
                'sale_documents.invoice_type_doc',
                'sale_documents.client_number',
                'sale_documents.client_rzn_social',
                'sale_documents.client_address',
                'sale_documents.client_ubigeo_code',
                'sale_documents.client_ubigeo_description',
                'sale_documents.client_phone',
                'sale_documents.client_email',
                'sale_documents.invoice_broadcast_date',
                'sale_documents.invoice_due_date'
            )
            ->whereIn('series.document_type_id', [1, 2])
            //->whereDate('sales.created_at', '=', $current_date)
            ->when(!$isAdmin, function ($q) use ($search) {
                return $q->where('sales.user_id', Auth::id());
            })
            ->when($search, function ($q) use ($search) {
                return $q->whereRaw('CONCAT("series.description","-",sale_documents.number) = ?', [$search])
                    ->orWhere('people.full_name', 'like', '%' . $search . '%');
            })
            ->with('documents.items') //agregar los detalles de documento
            ->paginate(10)
            ->onEachSide(2);

        $affectations = DB::table('sunat_affectation_igv_types')->get();
        $unitTypes = DB::table('sunat_unit_types')->get();

        return Inertia::render('Sales::Documents/List', [
            'documents'     => $sales,
            'filters'       => request()->all('search'),
            'affectations'  => $affectations,
            'unitTypes'     => $unitTypes,
            'taxes'         => array(
                'igv' => $this->igv,
                'icbper' => $this->icbper
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payments = PaymentMethod::all();
        $company = Company::first();


        $client = Person::find(1);
        $unitTypes = DB::table('sunat_unit_types')->get();
        $documentTypes = DB::table('identity_document_type')->get();
        $saleDocumentTypes = DB::table('sale_document_types')->whereIn('sunat_id', ['01', '03'])->get();
        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();

        $company->load('district.province.department');



        // Obtener el nombre de la ciudad usando los datos relacionados
        $city = $company->district->province->department->name . "-" . $company->district->province->name . "-" . $company->district->name;
        $company->city = $city;

        return Inertia::render('Sales::Documents/Create', [
            'payments'          => $payments,
            'client'            => $client,
            'documentTypes'     => $documentTypes,
            'saleDocumentTypes' => $saleDocumentTypes,
            'company'           => $company,
            'departments'       => $ubigeo,
            'unitTypes'         => $unitTypes,
            'type_operation'    => $this->top,
            'taxes'             => array(
                'igv' => $this->igv,
                'icbper' => $this->icbper
            )
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                'client_id' => 'required',
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
                $petty_cash = PettyCash::firstOrCreate([
                    'user_id' => Auth::id(),
                    'state' => 1,
                    'local_sale_id' => $local_id
                ], [
                    'date_opening' => Carbon::now()->format('Y-m-d'),
                    'time_opening' => date('H:i:s'),
                    'income' => 0
                ]);
                ///se crea la venta
                $sale = Sale::create([
                    'sale_date' => $request->get('date_issue'),
                    'user_id' => Auth::id(),
                    'client_id' => $request->get('client_id'),
                    'local_id' => $local_id,
                    'total' => $request->get('total'),
                    'advancement' => $request->get('total'),
                    'total_discount' => $request->get('total_discount'),
                    'payments' => json_encode($request->get('payments')),
                    'petty_cash_id' => $petty_cash->id,
                    'physical' => 2
                ]);

                ///obtenemos la serie elejida para hacer la venta
                ///para traer tambien su numero correlativo

                $serie = Serie::find($request->get('serie'));

                ///se convierte el total de la venta a letras
                $numberletters = new NumberLetter();
                $tido = SaleDocumentType::find($request->get('sale_documenttype_id'));
                ///creamos el documento de la venta para enviar a sunat
                $document = SaleDocument::create([
                    'sale_id'                       => $sale->id,
                    'serie_id'                      => $request->get('serie'),
                    'number'                        => str_pad($serie->number, 9, '0', STR_PAD_LEFT),
                    'status'                        => true,
                    'client_type_doc'               => $request->get('client_dti'),
                    'client_number'                 => $request->get('client_number'),
                    'client_rzn_social'             => $request->get('client_rzn_social'),
                    'client_address'                => $request->get('client_direction'),
                    'client_ubigeo_code'            => $request->get('client_ubigeo'),
                    'client_ubigeo_description'     => $request->get('client_ubigeo_description'),
                    'client_phone'                  => $request->get('client_phone'),
                    'client_email'                  => $request->get('client_email'),
                    'invoice_ubl_version'           => $this->ubl,
                    'invoice_type_operation'        => $request->get('type_operation'),
                    'invoice_type_doc'              => $tido->sunat_id,
                    'invoice_serie'                 => $serie->description,
                    'invoice_correlative'           => $serie->number,
                    'invoice_type_currency'         => 'PEN',
                    'invoice_broadcast_date'        => $request->get('date_issue'),
                    'invoice_due_date'              => $request->get('date_end'),
                    'invoice_send_date'             => Carbon::now()->format('Y-m-d'),
                    'invoice_legend_code'           => '1000',
                    'invoice_legend_description'    => $numberletters->convertToLetter($request->get('total')),
                    'invoice_status'                => 'registrado'
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
                            'purchase_prices'               => 0,
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
                        // le creamos un kardex en caso de ser un producto
                        if ($produc['is_product']) {
                            Kardex::create([
                                'date_of_issue'     => Carbon::now()->format('Y-m-d'),
                                'motion'            => 'purchase',
                                'product_id'        => $new_product->id,
                                'local_id'          => Auth::user()->local_id,
                                'quantity'          => $produc['quantity'],
                                'description'       => 'Stock Inicial',
                            ]);
                        }
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
                    SaleDocumentItem::create([
                        'document_id'           => $document->id,
                        'product_id'            => $product_id,
                        'cod_product'           => $interne,
                        'decription_product'    => $produc['description'],
                        'unit_type'             => $produc['unit_type'],
                        'quantity'              => $produc['quantity'],
                        'mto_base_igv'          => $mto_base_igv,
                        'percentage_igv'        => $this->igv,
                        'igv'                   => $igv,
                        'total_tax'             => $total_tax,
                        'type_afe_igv'          => $produc['afe_igv'],
                        'icbper'                => $icbper,
                        'factor_icbper'         => $porcentage_item_icbper,
                        'mto_value_sale'        => $value_sale,
                        'mto_value_unit'        => $value_unit,
                        'mto_price_unit'        => $unit_price,
                        'price_sale'            => $price_sale,
                        'mto_total'             => round($total_item, 2),
                        'mto_discount'          => $mto_discount ?? 0,
                        'json_discounts'        => json_encode($array_discounts)

                    ]);


                    if ($produc['is_product']) {
                        $k = Kardex::create([
                            'date_of_issue' => Carbon::now()->format('Y-m-d'),
                            'motion' => 'sale',
                            'product_id' => $product_id,
                            'local_id' => $local_id,
                            'quantity' => $produc['quantity'] * (-1),
                            'document_id' => $document->id,
                            'document_entity' => SaleDocument::class,
                            'description' => 'Venta'
                        ]);
                        $product = Product::find($product_id);
                        if ($product->presentations) {
                            KardexSize::create([
                                'kardex_id' => $k->id,
                                'product_id' => $product_id,
                                'local_id' => $local_id,
                                'size'      => $produc['size'],
                                'quantity'  => ($produc['quantity'] * (-1))
                            ]);
                            $tallas = $product->sizes;
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
                            $product->update([
                                'sizes' => json_encode($n_tallas)
                            ]);
                        }

                        Product::find($product_id)->decrement('stock', $produc['quantity']);
                    }
                    //fin parte de codigo actualiza el kardex

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

                $document->update([
                    'invoice_mto_oper_taxed'    => $mto_oper_taxed,
                    'invoice_mto_igv'           => $mto_igv,
                    'invoice_icbper'            => $total_icbper,
                    'invoice_total_taxes'       => $total_taxes,
                    'invoice_value_sale'        => $mto_oper_taxed,
                    'invoice_subtotal'          => $subtotal,
                    'invoice_rounding'          => $rounding,
                    'invoice_mto_imp_sale'      => $ttotal,
                    'invoice_sunat_points'      => null,
                    'invoice_status'            => 'Pendiente',
                ]);

                $serie->increment('number', 1);

                return $document;
            });

            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }


    public function getSerieByDocumentType($id)
    {
        $local_id = Auth::user()->local_id;
        $status = false;
        $series = Serie::where('document_type_id', $id)
            ->where('local_id', $local_id)
            ->get();

        if (count($series) > 0) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'status' => $status,
            'series' => $series
        ]);
    }

    public function sendSunatDocument($id, $type)
    {
        $result = array();

        switch ($type) {
            case '01':
                $factura = new Factura();
                $result = $factura->create($id);
                break;
            case '03':
                $boleta = new Boleta();
                $result = $boleta->create($id);
                break;
            case 2:
                echo "i es igual a 2";
                break;
        }


        return response()->json([
            'success' => $result['success'],
            'code'  => $result['code'],
            'message'   => $result['message'],
            'notes'   => $result['notes']
        ]);
    }

    public function updateDetailsAndHeader(Request $request)
    {
        //Los ejemplos de calculos para la version ubl 2.1 estan en una carpeta
        //en el proyecto en la direccion storage\app\public\invoice\manuales_guias_sunat
        try {
            $res = DB::transaction(function () use ($request) {
                $document = SaleDocument::find($request->get('id'));

                $items = $request->get('items');

                ///totales de la cabecera
                $mto_oper_taxed = 0;
                $mto_igv = 0;
                $total_icbper = 0;
                $porcentage_icbper = 0.20;
                $total_discount = 0;
                $total = 0;

                foreach ($items as $t => $item) {
                    /// imiciamos las variables para hacer los calculos por item;
                    $percentage_igv = $this->igv;
                    $mto_base_igv = 0;
                    $price_sale = $item['mto_price_unit'];
                    $nfactorIGV = round(($percentage_igv / 100) + 1, 2);
                    $ifactorIGV = round($percentage_igv / 100, 2);
                    $quantity = $item['quantity'];
                    $value_unit = 0;
                    $igv = 0;
                    $total_tax = 0;
                    $icbper = 0;
                    $value_sale = 0;
                    $total_item = 0;
                    $mto_discount = 0;
                    $array_discounts = [];

                    if ($item['type_afe_igv'] == '10') {
                        //valor unitario presio de venta / 1.IGV para quitarle el igv
                        //se tiene que quitar el igv porque el sistema trabaja con los precios
                        //incluido el igv
                        $value_unit = round($price_sale / $nfactorIGV, 2);
                        //la base para hacer el descuento 
                        $base = round($value_unit * $quantity, 2);
                        //el sistema resive un monto fijo como descuento y lo convierte a un porcentaje
                        $factor = (($item['mto_discount'] * 100) / $price_sale) / 100;
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
                        if ($item['mto_discount'] > 0) {
                            //el precio unitario se calcula
                            //(Valor venta + Total Impuestos) / Cantidad
                            $unit_price = round(($value_sale + $igv) / $quantity, 2);
                            $array_discounts[0] = array(
                                'value'     => $item['mto_discount'],
                                'type'      => '00',
                                'base'      => round($base, 2),
                                'factor'    => $factor,
                                'monto'     => round($descuento_monto, 2)
                            );
                        } else {
                            //el precio unitario es el mismo 
                            $unit_price = $price_sale;
                        }


                        //$mto_base_igv = $mto_base_igv - $item['mto_discount'];
                        $mto_discount = round($descuento_monto, 2);
                    }

                    if ($item['type_afe_igv'] == '20') { //Exonerated

                    }
                    if ($item['type_afe_igv'] == '30') { //Unaffected

                    }
                    if ($item['icbper'] == 1) {
                        $porcentage_item_icbper = $porcentage_icbper;
                        $icbper = ($quantity * $porcentage_item_icbper);
                    } else {
                        $porcentage_item_icbper = 0;
                        $icbper = 0;
                    }
                    $total_tax = $igv + $icbper;

                    //se inserta los datos al detalle del documento 
                    SaleDocumentItem::where('id', $item['id'])->update([
                        'decription_product'    => $item['decription_product'] ?? 'No Especificado',
                        'unit_type'             => $item['unit_type'],
                        'quantity'              => $quantity,
                        'mto_base_igv'          => $mto_base_igv,
                        'percentage_igv'        => $this->igv,
                        'igv'                   => $igv,
                        'total_tax'             => $total_tax,
                        'type_afe_igv'          => $item['type_afe_igv'],
                        'icbper'                => $icbper,
                        'factor_icbper'         => $porcentage_item_icbper,
                        'mto_value_sale'        => $value_sale,
                        'mto_value_unit'        => $value_unit,
                        'mto_price_unit'        => $unit_price,
                        'price_sale'            => $price_sale,
                        'mto_total'             => round($total_item, 2),
                        'mto_discount'          => $mto_discount ?? 0,
                        'json_discounts'        => json_encode($array_discounts)
                    ]);
                    //toda esta parte de codigo actualiza el kardex
                    $product = Product::find($item['id']);

                    if ($item['quantity'] > 0) {
                        if ($product->is_product) {
                            $k = Kardex::where('document_id', $document->id)
                                ->where('document_entity', SaleDocument::class)
                                ->first();

                            $quantity_old = $k->quantity;
                            $product->increment('stock', $quantity_old);
                            $k->update(['quantity' => $item['quantity'] * (-1)]);

                            if ($product->presentations) {
                                KardexSize::where('kardex_id', $k->id)->update([
                                    'quantity'  => $item['quantity'] * (-1)
                                ]);
                                $tallas = $product->sizes;
                                $n_tallas = [];
                                foreach (json_decode($tallas, true) as $k => $talla) {
                                    if ($talla['size'] == $product->size) {
                                        $n_tallas[$k] = array(
                                            'size' => $talla['size'],
                                            'quantity' => ($talla['quantity'] + $quantity_old)
                                        );
                                    } else {
                                        $n_tallas[$k] = array(
                                            'size' => $talla['size'],
                                            'quantity' => $talla['quantity']
                                        );
                                    }
                                }
                                foreach (json_decode($tallas, true) as $k => $talla) {
                                    if ($talla['size'] == $product->size) {
                                        $n_tallas[$k] = array(
                                            'size' => $talla['size'],
                                            'quantity' => ($talla['quantity'] - $item['quantity'])
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
                            $product->decrement('stock', $item['quantity']);
                        }
                    }
                    //fin parte de codigo actualiza el kardex

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

                $document->update([
                    'invoice_mto_oper_taxed'    => $mto_oper_taxed,
                    'invoice_mto_igv'           => $mto_igv,
                    'invoice_icbper'            => $total_icbper,
                    'invoice_total_taxes'       => $total_taxes,
                    'invoice_value_sale'        => $mto_oper_taxed,
                    'invoice_subtotal'          => $subtotal,
                    'invoice_rounding'          => $rounding,
                    'invoice_mto_imp_sale'      => $ttotal,
                    'invoice_sunat_points'      => null,
                    'invoice_status'            => 'Pendiente',
                ]);

                Sale::where('id', $document->sale_id)->update([
                    'total' => $ttotal,
                    'advancement' => $ttotal,
                    'total_discount' => $total_discount,
                ]);
                return $document->id;
            });

            return response()->json(['success' => true, 'message' => 'Se modificó los detalles correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function printDocument($id, $type, $file)
    {
        $res = array();
        $content_type = null;
        switch ($type) {
            case '01':
                $factura = new Factura();
                if ($file == 'PDF') {
                    $res = $factura->getFacturaPdf($id);
                    $content_type = 'application/pdf';
                } else if ($file == 'XML') {
                    $content_type =  'application/xml';
                    $res = $factura->getFacturaXML($id);
                } else {
                    $content_type =  'application/zip';
                    $res = $factura->getFacturaCDR($id);
                }

                break;
            case '03':
                $boleta = new Boleta();
                if ($file == 'PDF') {
                    $content_type = 'application/pdf';
                    $res = $boleta->getBoletatPdf($id);
                } else if ($file == 'XML') {
                    $content_type =  'application/xml';
                    $res = $boleta->getBoletaXML($id);
                } else {
                    $content_type =  'application/zip';
                    $res = $boleta->getBoletaCDR($id);
                }

                break;
            case 2:
                echo "i es igual a 2";
                break;
        }
        //return response()->file($res['filePath'], ['content-type' => 'application/pdf']);
        return response()->download($res['filePath'], $res['fileName'], ['content-type' => $content_type]);
    }

    public function createFromFicket($id)
    {
        $payments = PaymentMethod::all();
        $company = Company::first();
        $sale = Sale::with('saleProduct')
            ->where('id', $id)->first();

        $client = Person::find($sale->client_id);
        $unitTypes = DB::table('sunat_unit_types')->get();
        $documentTypes = DB::table('identity_document_type')->get();
        $saleDocumentTypes = DB::table('sale_document_types')->whereIn('sunat_id', ['01', '03'])->get();
        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();

        $company->load('district.province.department');

        // Obtener el nombre de la ciudad usando los datos relacionados
        $city = $company->district->province->department->name . "-" . $company->district->province->name . "-" . $company->district->name;
        $company->city = $city;
        if ($client->ubigeo) {
            $clientCity = $client->district->province->department->name . "-" . $client->district->province->name . "-" . $client->district->name;
            $client->city = $clientCity;
        } else {
            $client->city = $city;
        }

        return Inertia::render('Sales::Documents/CreateFromTicket', [
            'payments'          => $payments,
            'client'            => $client,
            'documentTypes'     => $documentTypes,
            'saleDocumentTypes' => $saleDocumentTypes,
            'company'           => $company,
            'departments'       => $ubigeo,
            'unitTypes'         => $unitTypes,
            'type_operation'    => $this->top,
            'sale'              => $sale,
            'taxes'             => array(
                'igv' => $this->igv,
                'icbper' => $this->icbper
            )
        ]);
    }

    public function updateHead(Request $request)
    {
        $this->validate($request, [
            'client_number'             => 'required',
            'client_rzn_social'         => 'required',
            'client_address'            => 'required',
            'client_ubigeo_code'        => 'required',
            'invoice_broadcast_date'    => 'required',
            'invoice_due_date'          => 'required'
        ]);

        SaleDocument::find($request->get('id'))
            ->update([
                'client_number'             => $request->get('client_number'),
                'client_rzn_social'         => $request->get('client_rzn_social'),
                'client_address'            => $request->get('client_address'),
                'client_phone'              => $request->get('client_phone'),
                'client_email'              => $request->get('client_email'),
                'client_ubigeo_code'        => $request->get('client_ubigeo_code'),
                'client_ubigeo_description' => $request->get('client_ubigeo_description'),
                'invoice_broadcast_date'    => $request->get('invoice_broadcast_date'),
                'invoice_due_date'          => $request->get('invoice_due_date')
            ]);

        Person::find($request->get('client_id'))
            ->update([
                'full_name' => $request->get('client_rzn_social'),
                'number'    => $request->get('client_number'),
                'telephone' => $request->get('client_phone'),
                'email'     => $request->get('client_email'),
                'address'   => $request->get('client_address'),
                'ubigeo'    => $request->get('client_ubigeo_code')
            ]);
    }

    public function storeFromTicket(Request $request)
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
                'client_id' => 'required',
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

                $sale_id = $request->get('sale_id');

                ///si no existe una caja abierta para el usuario logueado en la tienda donde inicio session
                ///se crea una caja para poder hacer la venta

                $local_id = Auth::user()->local_id;
                $petty_cash = PettyCash::firstOrCreate([
                    'user_id' => Auth::id(),
                    'state' => 1,
                    'local_sale_id' => $local_id
                ], [
                    'date_opening' => Carbon::now()->format('Y-m-d'),
                    'time_opening' => date('H:i:s'),
                    'income' => 0
                ]);
                ///se crea la venta
                $sale = Sale::find($sale_id);

                ///obtenemos la serie elejida para hacer la venta
                ///para traer tambien su numero correlativo

                $serie = Serie::find($request->get('serie'));

                ///se convierte el total de la venta a letras
                $numberletters = new NumberLetter();
                $tido = SaleDocumentType::find($request->get('sale_documenttype_id'));
                ///creamos el documento de la venta para enviar a sunat
                $document = SaleDocument::create([
                    'sale_id'                       => $sale->id,
                    'serie_id'                      => $request->get('serie'),
                    'number'                        => str_pad($serie->number, 9, '0', STR_PAD_LEFT),
                    'status'                        => true,
                    'client_type_doc'               => $request->get('client_dti'),
                    'client_number'                 => $request->get('client_number'),
                    'client_rzn_social'             => $request->get('client_rzn_social'),
                    'client_address'                => $request->get('client_direction'),
                    'client_ubigeo_code'            => $request->get('client_ubigeo'),
                    'client_ubigeo_description'     => $request->get('client_ubigeo_description'),
                    'client_phone'                  => $request->get('client_phone'),
                    'client_email'                  => $request->get('client_email'),
                    'invoice_ubl_version'           => $this->ubl,
                    'invoice_type_operation'        => $request->get('type_operation'),
                    'invoice_type_doc'              => $tido->sunat_id,
                    'invoice_serie'                 => $serie->description,
                    'invoice_correlative'           => $serie->number,
                    'invoice_type_currency'         => 'PEN',
                    'invoice_broadcast_date'        => $request->get('date_issue'),
                    'invoice_due_date'              => $request->get('date_end'),
                    'invoice_send_date'             => Carbon::now()->format('Y-m-d'),
                    'invoice_legend_code'           => '1000',
                    'invoice_legend_description'    => $numberletters->convertToLetter($request->get('total')),
                    'invoice_status'                => 'registrado'
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

                    $product_id = $produc['id'];
                    $interne = $produc['interne'];

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
                    SaleDocumentItem::create([
                        'document_id'           => $document->id,
                        'product_id'            => $product_id,
                        'cod_product'           => $interne,
                        'decription_product'    => $produc['description'],
                        'unit_type'             => $produc['unit_type'],
                        'quantity'              => $produc['quantity'],
                        'mto_base_igv'          => $mto_base_igv,
                        'percentage_igv'        => $this->igv,
                        'igv'                   => $igv,
                        'total_tax'             => $total_tax,
                        'type_afe_igv'          => $produc['afe_igv'],
                        'icbper'                => $icbper,
                        'factor_icbper'         => $porcentage_item_icbper,
                        'mto_value_sale'        => $value_sale,
                        'mto_value_unit'        => $value_unit,
                        'mto_price_unit'        => $unit_price,
                        'price_sale'            => $price_sale,
                        'mto_total'             => round($total_item, 2),
                        'mto_discount'          => $mto_discount ?? 0,
                        'json_discounts'        => json_encode($array_discounts)

                    ]);

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

                $document->update([
                    'invoice_mto_oper_taxed'    => $mto_oper_taxed,
                    'invoice_mto_igv'           => $mto_igv,
                    'invoice_icbper'            => $total_icbper,
                    'invoice_total_taxes'       => $total_taxes,
                    'invoice_value_sale'        => $mto_oper_taxed,
                    'invoice_subtotal'          => $subtotal,
                    'invoice_rounding'          => $rounding,
                    'invoice_mto_imp_sale'      => $ttotal,
                    'invoice_sunat_points'      => null,
                    'invoice_status'            => 'Pendiente',
                ]);

                $serie->increment('number', 1);

                return $document;
            });

            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
