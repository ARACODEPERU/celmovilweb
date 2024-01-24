<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Onlineshop\Entities\OnliItem;

use Intervention\Image\Facades\Image;
use Intervention\Image\Font;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class WebController extends Controller
{
    public function index()
    {

        $products_main = OnliItem::with('product')
            ->where('additional5', 'PR')
            ->orderBy('id', 'DESC')
            ->paginate(5);

        return view('pages/index', [
            'products_main' => $products_main
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

    public function carrito()
    {
        return view('pages/carrito');
    }
}
