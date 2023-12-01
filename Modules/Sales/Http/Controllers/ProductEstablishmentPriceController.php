<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\ProductEstablishmentPrice;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProductEstablishmentPriceController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductEstablishmentPrice  $productEstablishmentPrice
     * @return \Illuminate\Http\Response
     */
    public function show(ProductEstablishmentPrice $productEstablishmentPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductEstablishmentPrice  $productEstablishmentPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductEstablishmentPrice $productEstablishmentPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductEstablishmentPrice  $productEstablishmentPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductEstablishmentPrice $productEstablishmentPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductEstablishmentPrice  $productEstablishmentPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductEstablishmentPrice $productEstablishmentPrice)
    {
        //
    }
}
