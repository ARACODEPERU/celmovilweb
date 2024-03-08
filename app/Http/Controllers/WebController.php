<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
use Intervention\Image\Font;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Modules\CMS\Entities\CmsItem;
use Modules\CMS\Entities\CmsSection;
use Modules\Onlineshop\Entities\OnliItem;


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

        return view('pages/index', [
            'sliders' => $sliders,
            'products_main' => $products_main
        ]);
    }

    public function nosotros()
    {
        return view('pages/nosotros');
    }

    public function productocategoria($id)
    {
        $products = OnliItem::join('products', 'onli_items.item_id', 'products.id')
            ->select(
                'onli_items.*'
            )
            ->where('products.category_id', $id)
            ->paginate(16)
            ->onEachSide(2);

        return view('pages/producto-categoria', [
            'products' => $products
        ]);
    }


    public function productodescripcion($id)
    {
        $product = OnliItem::with('images')
            ->with('product')
            ->with('specifications')
            ->where('id', $id)
            ->first();
        //dd($product);
        return view('pages/producto-descripcion', [
            'product' => $product
        ]);
    }

    public function carrito(Request $request)
    {

        return view('pages/carrito');
    }

    public function pagar()
    {
        return view('pages/pagar');
    }
}
