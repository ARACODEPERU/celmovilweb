<?php

namespace Modules\Socialevents\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Socialevents\Entities\EvenCategory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

class EvenCategoryController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gategories = (new EvenCategory())->newQuery();

        if (request()->has('search')) {
            $gategories->where('description', 'Like', '%' . request()->input('search') . '%');
        }

        $gategories = $gategories->paginate(10);

        return Inertia::render('Socialevents::Categories/List', [
            'categories' => $gategories,
            'filters' => request()->all('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Socialevents::Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate(
            $request,
            [
                'description'   => 'required'
            ]
        );

        EvenCategory::create([
            'icon'          => null,
            'description'   => $request->get('description'),
            'status'        => $request->get('status') ? true : false,
        ]);

        return to_route('even_categories_list');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('socialevents::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = EvenCategory::find($id);
        return Inertia::render('Socialevents::Categories/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'description'   => 'required'
            ]
        );
        $category = EvenCategory::find($request->get('id'));
        $category->description =  $request->get('description');
        $category->status = $request->get('status') ? true : false;

        $category->save();
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
            $item = EvenCategory::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Categoría eliminada correctamente';
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
