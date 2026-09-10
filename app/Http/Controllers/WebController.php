<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmPurchaseMail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Intervention\Image\Font;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Modules\CMS\Entities\CmsItem;
use Modules\CMS\Entities\CmsSection;
use Modules\Onlineshop\Entities\OnliItem;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use Modules\CMS\Entities\CmsSectionItem;
use Modules\Onlineshop\Entities\OnliSale;
use Modules\Onlineshop\Entities\OnliSaleDetail;
use Modules\Sales\Entities\SaleProductCategory;
use App\Mail\ComplaintsBookMail;

class WebController extends Controller
{

    public function index()
    {

        $sliders = CmsSection::where('component_id', 'slider_3')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();
        
        
        $portadas = CmsSection::where('component_id', 'portadas_home_movil_14')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();


        $products_main = OnliItem::with('product')
            ->where('additional5', 'PR')
            ->where('existence', 1)
            ->orderBy('id', 'DESC')
            ->paginate(5);


        $algunos_modelos = CmsSectionItem::with('item.items')->where('section_id', 13)  //cambiar el id de la seccion ->sedes ubicacion 24
        ->orderBy('position')
        ->get();

        // Obtener todos los IDs de subcategorías que pertenecen a la categoría 27 (Accesorios)
        $accessory_ids = SaleProductCategory::where('category_id', 27)
            ->pluck('id')
            ->toArray();

        if(empty($accessory_ids)){
            $accessory_ids = [27];
        }

        $accessories = OnliItem::join('products', 'onli_items.item_id', 'products.id')
            ->select('onli_items.*')
            ->with('product')
            ->whereIn('products.category_id', $accessory_ids) // Buscar en la categoría y sus hijos
            ->where('onli_items.existence', 1)
            ->inRandomOrder()
            ->take(15)
            ->get();

        $ofprincipal = CmsSection::where('component_id', 'oficina_principal_area_12')  //siempre cambiar el id del componente
        ->join('cms_section_items', 'section_id', 'cms_sections.id')
        ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
        ->select(
            'cms_items.content',
            'cms_section_items.position'
        )
        ->orderBy('cms_section_items.position')
        ->get();


        return view('pages/index', [
            'sliders' => $sliders,
            'portadas' => $portadas,
            'products_main' => $products_main,
            'algunos_modelos' => $algunos_modelos,
            'ofprincipal' => $ofprincipal,
            'accessories' => $accessories,
            'seo_title' => 'CELMOVIL || Perú - Motos Eléctricas en Trujillo',
            'seo_description' => 'Líder en Motos Eléctricas La Libertad. Representante de las marcas TOP con servicio técnico especializado. Envíos a todo el Perú.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

    public function nosotros()
    {
        $banner = CmsSection::where('component_id', 'banner_nosotros_6')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();
        
            
        $presentation = CmsSection::where('component_id', 'nosotros_presentacion_17')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();
        
            
        $elegirnos = CmsSection::where('component_id', 'nosotros_elegirnos_18')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        return view('pages/nosotros', [
            'banner' => $banner,
            'presentation' => $presentation,
            'elegirnos' => $elegirnos,
            'seo_title' => 'Nosotros | CELMOVIL - Motos Eléctricas',
            'seo_description' => 'Conoce a CELMOVIL, líder en motos eléctricas en La Libertad. Nuestra misión es promover la movilidad eléctrica en Perú con calidad y garantía.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

    public function politicasprivacidad()
    {
        $banner = CmsSection::where('component_id', 'banner_nosotros_6')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        return view('pages/politicas-de-privacidad', [
            'banner' => $banner,
            'seo_title' => 'Políticas de Privacidad | CELMOVIL',
            'seo_description' => 'Conoce nuestras políticas de privacidad en CELMOVIL. Protegemos tu información personal y garantizamos la seguridad de tus datos.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

    public function productoPrincipal($id){

        $banner = CmsSection::where('component_id', 'banner_productos_categoria_4')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

            $ids = SaleProductCategory::where('category_id', $id)
            ->pluck('id')
            ->toArray();

            if(empty($ids)){
                $ids=[$id];
            }

            $products = OnliItem::join('products', 'onli_items.item_id', 'products.id')
            ->select('onli_items.*')
            ->with('product')
            ->whereIn('products.category_id', $ids)
            ->where('onli_items.existence', 1)
            ->orderBy('onli_items.created_at', 'desc')
            ->paginate(150)
            ->onEachSide(2);

        $categoryNames = [
            1 => 'Motos Eléctricas',
            2 => 'Trimotos Eléctricas',
            3 => 'Cuatrimotos Eléctricas',
            6 => 'VMPs, Bicimotos y Bicicletas Eléctricas',
            26 => 'Repuestos',
            27 => 'Accesorios',
            28 => 'Cargueros Eléctricos',
        ];
        $categoryName = $categoryNames[$id] ?? 'Productos';

        return view('pages/productos', [
            'banner' => $banner,
            'products' => $products,
            'category_id' => $id,
            'seo_title' => $categoryName . ' en Trujillo | CELMOVIL',
            'seo_description' => 'Explora nuestros ' . strtolower($categoryName) . ' de marcas TOP. Los mejores precios y garantía. Envíos a todo el Perú.',
            'og_image' => $products->isNotEmpty() && $products->first()->image ? asset($products->first()->image) : asset('themes/celmovil/img/logoCM.png'),
        ]);

    }

    public function productocategoria($id)
    {

        $banner = CmsSection::where('component_id', 'banner_productos_categoria_4')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        $products = OnliItem::join('products', 'onli_items.item_id', 'products.id')
            ->select('onli_items.*')
            ->with('product')
            ->where('products.category_id', $id)
            ->where('onli_items.existence', 1)
            ->orderBy('onli_items.created_at', 'desc') // Ordenar en forma descendente por la columna 'created_at'
            ->paginate(30)
            ->onEachSide(2);

        $categoryName = $products->isNotEmpty() ? $products->first()->category_description : 'Productos';

        return view('pages/producto-categoria', [
            'banner' => $banner,
            'products' => $products,
            'seo_title' => $categoryName . ' | CELMOVIL - Compra Online',
            'seo_description' => 'Compra ' . $categoryName . ' al mejor precio en CELMOVIL. Envíos a todo el Perú con garantía y servicio técnico.',
            'og_image' => $products->isNotEmpty() && $products->first()->image ? asset($products->first()->image) : asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

    public function productodescripcion($slug)
    {
        $banner = CmsSection::where('component_id', 'banner_productos_descripcion_5')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        $product = OnliItem::with('images')
            ->with('product')
            ->with('specifications')
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            abort(404);
        }

        $productDescription = strip_tags($product->description ?? '');
        $productDescription = mb_substr($productDescription, 0, 160, 'UTF-8');
        if (mb_strlen(strip_tags($product->description ?? '')) > 160) {
            $productDescription .= '...';
        }

        return view('pages/producto-descripcion', [
            'banner' => $banner,
            'product' => $product,
            'seo_title' => $product->name . ' | CELMOVIL - Precio y Disponibilidad',
            'seo_description' => $productDescription ?: 'Compra ' . $product->name . ' al mejor precio en CELMOVIL. Envío a todo el Perú con garantía.',
            'og_image' => $product->image ? asset($product->image) : asset('themes/celmovil/img/logoCM.png'),
            'og_type' => 'product',
        ]);
    }

    public function carrito()
    {
        $banner = CmsSection::where('component_id', 'banner_carrito_9')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        return view('pages/carrito', [
            'banner' => $banner,
            'seo_title' => 'Mi Carrito | CELMOVIL',
            'seo_description' => 'Revisa los productos en tu carrito de compras en CELMOVIL.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

    public function pagar(Request $request)
    {
        $productids = $request->get('product_id');
        $productnames = $request->get('product_name');
        $productquantitys = $request->get('product_quantity');
        $productprices = $request->get('product_price');

        $comprador_nombre = $request->get('names');
        $comprador_telefono = $request->get('phone');

        $preference_id = null;
        try {

            MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_TOKEN'));
            $client = new PreferenceClient();
            $items = [];
            $products = [];
            $total = 0;

            $sale = OnliSale::create([
                'module_name'                   => 'Onlineshop',
                'person_id'                     => null,
                'clie_full_name'                => $comprador_nombre,
                'phone'                         => $comprador_telefono,
                'email'                         => null,
                'response_status'               => 'pendiente',
            ]);

            foreach ($productids as $key => $id) {
                array_push($items, [
                    'id' => $id,
                    'title' => $productnames[$key],
                    'quantity'      => floatval($productquantitys[$key]),
                    'currency_id'   => 'PEN',
                    'unit_price'    => floatval($productprices[$key])
                ]);

                $product = OnliItem::find($id);

                array_push($products, [
                    'image' => $product->image,
                    'name' => $product->name,
                    'price' => floatval($productprices[$key]),
                    'quantity'      => floatval($productquantitys[$key]),
                    'total' => (floatval($productquantitys[$key]) * floatval($productprices[$key]))
                ]);

                $total = $total + (floatval($productquantitys[$key]) * floatval($productprices[$key]));

                OnliSaleDetail::create([
                    'sale_id'       => $sale->id,
                    'item_id'       => $product->item_id,
                    'entitie'       => $product->entitie,
                    'price'         => $product->price-$product->discount,
                    'quantity'      => floatval($productquantitys[$key]),
                    'onli_item_id'  => $id
                ]);
            }

            $preference = $client->create([
                "items" => $items,
            ]);

            // $preference->back_urls = array(
            //     "success" => route('web_gracias_por_comprar_tu_entrada', $sale->id),
            //     // "failure" => "http://www.tu-sitio/failure",
            //     // "pending" => "http://www.tu-sitio/pending"
            // );

            $preference_id =  $preference->id;
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // Manejar la excepción

            $response = $e->getApiResponse();
            dd($response); // Mostrar la respuesta para obtener más detalles
        }

        return view('pages/pagar', [
            'preference' => $preference_id,
            'products' => $products,
            'total' => $total,
            'sale_id' => $sale->id
        ]);
    }

    public function preguntas()
    {
        $banner = CmsSection::where('component_id', 'banner_preguntas_frecuentes_7')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        return view('pages/preguntas-frecuentes', [
            'banner' => $banner,
            'seo_title' => 'Preguntas Frecuentes | CELMOVIL - Motos Eléctricas',
            'seo_description' => 'Resuelve tus dudas sobre motos eléctricas, baterías, mantenimiento, garantía y servicio técnico en CELMOVIL.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }


    public function claims()
    {
        $banner = CmsSection::where('component_id', 'banner_nosotros_6')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        return view('pages/complaints-book', [
            'banner' => $banner,
            'seo_title' => 'Libro de Reclamaciones | CELMOVIL',
            'seo_description' => 'Registra tu queja o reclamo en CELMOVIL. Cumplimos con la normativa del INDECOPI para la protección del consumidor.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

    public function eclaims()
    {

        return view('emails/e_complaints_book');
    }

    public function processPayment(Request $request, $id)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_TOKEN'));

        $client = new PaymentClient();
        $sale = OnliSale::find($id);

        if ($sale->response_status == 'approved') {
            return response()->json(['error' => 'el pedido ya fue procesado, ya no puede volver a pagar'], 412);
        } else {
            try {

                $payment = $client->create([
                    "token" => $request->get('token'),
                    "issuer_id" => $request->get('issuer_id'),
                    "payment_method_id" => $request->get('payment_method_id'),
                    "transaction_amount" => (float) $request->get('transaction_amount'),
                    "installments" => $request->get('installments'),
                    "payer" => $request->get('payer')
                ]);



                if ($payment->status == 'approved') {

                    $sale->email = $request->get('payer')['email'];
                    $sale->total = $request->get('transaction_amount');
                    $sale->identification_type = $request->get('payer')['identification']['type'];
                    $sale->identification_number = $request->get('payer')['identification']['number'];
                    $sale->response_status = $payment->status;
                    $sale->response_id = $request->get('collection_id');
                    $sale->response_date_approved = Carbon::now()->format('Y-m-d');
                    $sale->response_payer = json_encode($request->all());
                    $sale->response_payment_method_id = $request->get('payment_type');
                    $sale->mercado_payment_id = $payment->id;
                    $sale->mercado_payment = json_encode($payment);

                    ///enviar correo
                    Mail::to($sale->email)
                        ->send(new ConfirmPurchaseMail(OnliSale::with('details.item')->where('id', $id)->first()));

                    $sale->save();

                    return response()->json([
                        'status' => $payment->status,
                        'message' => $payment->status_detail,
                        'url' => route('web_gracias_por_comprar_tu_entrada', $sale->id)
                    ]);
                } else {

                    return response()->json([
                        'status' => $payment->status,
                        'message' => $payment->status_detail,
                        'url' => route('web_pagar')
                    ]);

                    $sale->delete();
                }
            } catch (\MercadoPago\Exceptions\MPApiException $e) {
                // Manejar la excepción
                $response = $e->getApiResponse();
                $content  = $response->getContent();

                $message = $content['message'];
                return response()->json(['error' => 'Error al procesar el pago: ' . $message], 412);
            }
        }
    }

    public function graciasCompra($id)
    {
        $products[0] = null;
        $sale = OnliSale::where('id', $id)->with('details.item')->first();
        return view('pages/gracias-compra', [
            'products' => $products,
            'sale' => $sale
        ]);
    }

    public function errorCompra($id)
    {
        dd($id);
    }

    public function send_claim(Request $request)
    {
        $data = $request->all();

        $recipient = $data['email'];
        Mail::to($recipient)->send(new ComplaintsBookMail($data));

        $recipient = env('MAIL_FROM_ADDRESS');
        $data['ours'] = true;
        Mail::to($recipient)->send(new ComplaintsBookMail($data));

        return view('emails.e_complaints_book')->with('complaints', $data);
    }

    public function searchProducts(Request $request)
    {
        $search = $request->input('search');

        // Reutilizamos el banner de categorías para mantener el estilo visual
        $banner = CmsSection::where('component_id', 'banner_productos_categoria_4')
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        // Búsqueda en OnliItem y Product relacionado
        $products = OnliItem::join('products', 'onli_items.item_id', 'products.id')
            ->select('onli_items.*')
            ->with('product')
            ->where(function ($query) use ($search) {
                $query->where('products.description', 'LIKE', "%{$search}%")
                    ->orWhere('onli_items.name', 'LIKE', "%{$search}%");
            })
            ->where('onli_items.existence', 1)
            ->orderBy('onli_items.created_at', 'desc')
            ->paginate(20);

        return view('pages/search', [
            'products' => $products,
            'search' => $search,
            'banner' => $banner,
            'seo_title' => 'Resultados: ' . $search . ' | CELMOVIL',
            'seo_description' => 'Resultados de búsqueda para "' . $search . '" en CELMOVIL. Encuentra motos eléctricas, accesorios y repuestos.',
            'og_image' => asset('themes/celmovil/img/logoCM.png'),
        ]);
    }

}
