<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LocalSale;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function index()
    {

        $products = (new Product())->newQuery()->where('is_product', false);

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

        return Inertia::render('Sales::Services/List', [
            'products' => $products,
            'establishments' => $establishments,
            'filters' => [
                'search' => request()->input('search')
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Sales::Services/Create', [
            'establishments' => LocalSale::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'interne' => 'required|unique:products,interne',
                'description' => 'required',
                'sale_prices.high' => 'required'
            ]
        );
        Product::create([
            'usine' => $request->get('usine'),
            'interne' => $request->get('interne'),
            'description' => $request->get('description'),
            'image' => 'img/imagen-no-disponible.jpg',
            'purchase_prices' => 0,
            'sale_prices' => json_encode($request->get('sale_prices')),
            'sizes' => null,
            'stock_min' => 1,
            'stock' => 1,
            'presentations' => false,
            'is_product' => false,
            'type_sale_affectation_id' => '10',
            'type_purchase_affectation_id' => '10',
            'type_unit_measure_id' => 'ZZ',
            'status' => true
        ]);
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
        return Inertia::render('Sales::Services/Edit', [
            'establishments' => LocalSale::all(),
            'product' => Product::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'interne' => 'required|unique:products,interne,' . $id,
                'description' => 'required',
                'sale_prices.high' => 'required'
            ]
        );

        $porduct = Product::find($id);

        $porduct->update([
            'usine' => $request->get('usine'),
            'interne' => $request->get('interne'),
            'description' => $request->get('description'),
            'image' => 'img/imagen-no-disponible.jpg',
            'purchase_prices' => 0,
            'sale_prices' => json_encode($request->get('sale_prices')),
            'sizes' => null,
            'stock_min' => 1,
            'stock' => 1,
            'presentations' => false,
            'is_product' => false,
            'type_sale_affectation_id' => '10',
            'type_purchase_affectation_id' => '10',
            'type_unit_measure_id' => 'ZZ',
            'status' => $request->get('status') ? true : false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            // Verificamos si existe.
            $item = Product::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Servicio eliminado correctamente';
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
