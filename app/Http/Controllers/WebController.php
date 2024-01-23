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
        return view('pages/index');
    }

    public function productodescripcion($id)
    {
        $product = OnliItem::with('images')
            ->with('product')
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
