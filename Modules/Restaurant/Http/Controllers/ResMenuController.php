<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Entities\ResComanda;
use Modules\Restaurant\Entities\ResMenu;

class ResMenuController extends Controller
{
    use ValidatesRequests;

    protected $RPTABLE;

    public function __construct()
    {
        $this->RPTABLE = env('RECORDS_PAGE_TABLE') ?? 10;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = (new ResMenu())->newQuery();
        if (request()->has('search')) {
            $menus->where('name', 'like', '%' . request()->input('search') . '%');
        }
        $menus = $menus->paginate($this->RPTABLE)->onEachSide(2);

        return Inertia::render('Restaurant::Menus/List', [
            'menus' => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Restaurant::Menus/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'          => 'required',
                'description'   => 'required|max:355',
            ]
        );

        ResMenu::create([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'status' => $request->get('status') ?? false
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $resmenu = ResMenu::with('comandas.comanda')->where('id', $id)->first();

        return Inertia::render('Restaurant::Menus/Print', [
            'resmenu' => $resmenu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resmenu = ResMenu::find($id);
        return Inertia::render('Restaurant::Menus/Edit', [
            'resmenu' => $resmenu
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
                'name'          => 'required',
                'description'   => 'required|max:355',
            ]
        );

        ResMenu::find($id)->update([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'status' => $request->get('status') ?? false
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
            $item = ResMenu::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Comanda eliminada correctamente';
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
