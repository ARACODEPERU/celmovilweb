<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LocalSale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function index()
    {
        $product = request()->input('displayProduct') ? request()->input('displayProduct') : true;

        $true =  true;

        if ($product === true || $product === 'true') {
            $true =  true;
        } else {
            $true =  false;
        }

        $products = (new Product())->newQuery()->where('is_product', $true);

        if (request()->has('search')) {
            $products->where(function ($query) {
                $query->where('interne', '=', request()->input('search'))
                    ->orWhere('description', 'Like', '%' . request()->input('search') . '%');
            });
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $products->orderBy($attribute, $sort_order);
        } else {
            $products->latest();
        }
        //dd($products->toRawSql());
        $products = $products->paginate(10)->onEachSide(2);


        $establishments = LocalSale::all();

        return Inertia::render('Sales::Products/List', [
            'products' => $products,
            'establishments' => $establishments,
            'filters' => [
                'search' => request()->input('search'),
                'displayProduct'  => $product
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
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
        //
    }
}
