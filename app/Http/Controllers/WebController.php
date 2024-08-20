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
use Modules\Onlineshop\Entities\OnliSale;
use Modules\Onlineshop\Entities\OnliSaleDetail;

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
            

        $products_main = OnliItem::with('product')
            ->where('additional5', 'PR')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        
            

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
            'products_main' => $products_main,
            'ofprincipal' => $ofprincipal
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

        return view('pages/nosotros', [
            'banner' => $banner
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
            'banner' => $banner
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
            ->select(
                'onli_items.*'
            )
            ->with('product')
            ->where('products.category_id', $id)
            ->paginate(16)
            ->onEachSide(2);

        return view('pages/producto-categoria', [
            'banner' => $banner,
            'products' => $products
        ]);
    }


    public function productodescripcion($id)
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
            ->where('id', $id)
            ->first();
        //dd($product->category_description);
        return view('pages/producto-descripcion', [
            'banner' => $banner,
            'product' => $product
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
            'banner' => $banner
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
                    'price'         => $product->price,
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
            'banner' => $banner
        ]);
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
                        'url' => route('web_eventos_pagar', $id)
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

}
