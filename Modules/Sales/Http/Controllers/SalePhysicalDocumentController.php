<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\District;
use App\Models\Kardex;
use App\Models\KardexSize;
use App\Models\Parameter;
use App\Models\PaymentMethod;
use App\Models\Person;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Sales\Entities\SalePhysicalDocument;

class SalePhysicalDocumentController extends Controller
{
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
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = (new SalePhysicalDocument())->newQuery();

        $search = request()->input('search');

        $isAdmin = Auth::user()->hasRole('admin');

        $sales = $sales->when($search, function ($q) use ($search) {
            return $q->where('corelative', 'like', '%' . $search . '%');
        })->orderBy('id', 'DESC')
            ->paginate(10)
            ->onEachSide(2);

        return Inertia::render('Sales::PhysicalDocument/List', [
            'sales' => $sales,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
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

        return Inertia::render('Sales::PhysicalDocument/Create', [
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
     */
    public function store(Request $request)
    {
        ///se validan los campos requeridos
        $this->validate(
            $request,
            [
                'serie' => 'required',
                'corelative' => 'required',
                'date_issue' => 'required',
                'date_end' => 'required',
                'sale_documenttype_id' => 'required',
                'total' => 'required|numeric|min:0|not_in:0',
                'payments.*.type' => 'required',
                'payments.*.amount' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'items.*.quantity' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'items.*.unit_price' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'items.*.total' => 'required|numeric|min:0|not_in:0|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
                'client_rzn_social' => 'required',
                'client_name' => 'required',
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
                $tk = Sale::create([
                    'sale_date' => Carbon::now()->format('Y-m-d'),
                    'user_id' => Auth::id(),
                    'client_id' => $request->get('client_id'),
                    'local_id' => $local_id,
                    'total' => $request->get('total'),
                    'advancement' => $request->get('total'),
                    'total_discount' => $request->get('total_discount'),
                    'payments' => json_encode($request->get('payments')),
                    'petty_cash_id' => $petty_cash->id,
                    'physical' => 3
                ]);

                $sale = SalePhysicalDocument::create([
                    'sale_id' => $tk->id,
                    'user_id' => Auth::id(),
                    'serie' => $request->get('serie'),
                    'corelative' => $request->get('corelative'),
                    'document_date' => $request->get('date_issue'),
                    'document_expiration' => $request->get('date_end'),
                    'client_id' => $request->get('client_id'),
                    'client_type_doc' => $request->get('client_dti'),
                    'client_number' => $request->get('client_number'),
                    'client_rzn_social' => $request->get('client_rzn_social'),
                    'client_address' => $request->get('client_direction'),
                    'client_ubigeo_code' => $request->get('client_ubigeo'),
                    'client_ubigeo_description' => $request->get('client_ubigeo_description'),
                    'client_phone' => $request->get('client_phone'),
                    'client_email' => $request->get('client_email'),
                    'payments' => json_encode($request->get('payments')),
                    'total' => $request->get('total'),
                    'status' => 'R'
                ]);


                ///obtenemos los productos o servicios para insertar en los 
                ///detalles de la venta y el documento
                $products = $request->get('items');
                $items = [];
                foreach ($products as $produc) {
                    $product_id = null;
                    $interne = null;
                    if ($produc['id']) {
                        $product_id = $produc['id'];
                        $interne = $produc['interne'];
                        array_push($items, $produc);
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
                        $produc['id'] = $product_id;
                        $produc['usine'] = $randomNumberPadded;
                        $produc['interne'] = $randomNumberPadded;

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

                        array_push($items, $produc);
                    }

                    if ($produc['is_product']) {
                        $k = Kardex::create([
                            'date_of_issue' => Carbon::now()->format('Y-m-d'),
                            'motion' => 'sale',
                            'product_id' => $product_id,
                            'local_id' => $local_id,
                            'quantity' => $produc['quantity'] * (-1),
                            'document_id' => $sale->id,
                            'document_entity' => SalePhysicalDocument::class,
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

                        SaleProduct::create([
                            'sale_id' => $tk->id,
                            'product_id' => $product_id,
                            'product' => json_encode(Product::find($product_id)),
                            'saleProduct' => json_encode($produc),
                            'size'      => $produc['size'],
                            'price' => $produc['unit_price'],
                            'discount' => $produc['discount'],
                            'quantity' => $produc['quantity'],
                            'total' => $produc['total']
                        ]);

                        Product::find($product_id)->decrement('stock', $produc['quantity']);
                    }
                    //fin parte de codigo actualiza el kardex

                }

                $sale->products = json_encode($items);
                $sale->save();
                return $sale;
            });

            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('sales::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {

            DB::beginTransaction();

            $dos = SalePhysicalDocument::findOrFail($id);
            $sal = Sale::findOrFail($dos->sale_id);

            $dos->update(['status' => 'A']);

            $sal->update(['status' => false]);

            $sal_pros = SaleProduct::where('sale_id', $sal->id)->get();

            foreach ($sal_pros as $sal_pro) {
                $k = Kardex::create([
                    'date_of_issue' => Carbon::now()->format('Y-m-d'),
                    'motion' => 'sale',
                    'product_id' => $sal_pro->product_id,
                    'local_id' => $sal->local_id,
                    'quantity' => $sal_pro->quantity,
                    'document_id' => $dos->id,
                    'document_entity' => SalePhysicalDocument::class,
                    'description' => 'Venta Anulada'
                ]);
                $product = Product::find($sal_pro->product_id);
                if ($product->presentations) {
                    KardexSize::create([
                        'kardex_id' => $k->id,
                        'product_id' => $product->id,
                        'local_id' => $sal->local_id,
                        'size'      => json_decode($sal_pro->product)['size'],
                        'quantity'  => $sal_pro->quantity
                    ]);
                    $tallas = $product->sizes;
                    $n_tallas = [];
                    foreach (json_decode($tallas, true) as $k => $talla) {
                        if ($talla['size'] == json_decode($sal_pro->product)['size']) {
                            $n_tallas[$k] = array(
                                'size' => $talla['size'],
                                'quantity' => ($talla['quantity'] + $sal_pro->quantity)
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
                Product::find($sal_pro->product_id)->decrement('stock', $sal_pro->quantity);
            }

            DB::commit();

            $message =  'Documento anulado correctamente';
            $success = true;
        } catch (\Exception $e) {
            // Si ocurre alguna excepción durante la transacción, hacemos rollback para deshacer cualquier cambio.
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
