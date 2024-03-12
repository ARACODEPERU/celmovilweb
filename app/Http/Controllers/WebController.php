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
        //dd($product);
        return view('pages/producto-descripcion', [
            'banner' => $banner,
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
}
