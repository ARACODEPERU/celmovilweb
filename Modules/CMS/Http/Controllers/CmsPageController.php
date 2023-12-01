<?php

namespace Modules\CMS\Http\Controllers;

use App\Models\Country;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\CMS\Entities\CmsPage;

class CmsPageController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $pages = (new CmsPage())->newQuery();
        if (request()->has('search')) {
            $pages->where('description', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $pages->orderBy($attribute, $sort_order);
        } else {
            $pages->latest();
        }

        $pages = $pages->paginate(20)->onEachSide(2);

        return Inertia::render('CMS::Pages/List', [
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $countries = Country::where('status', true)->get();

        return Inertia::render('CMS::Pages/Create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'description' => 'required|string',
                'route' => 'required',
            ],
            [
                'description.required' => 'el campo descripción es obligatorio',
                'description.string' => 'el campo descripción solo acepta letras',
                'route.required' => 'el campo ruta es obligatorio',
            ]
        );

        CmsPage::create([
            'description'   => $request->get('description'),
            'icon'          => $request->get('icon'),
            'route'         => $request->get('route'),
            'main'          => $request->get('main'),
            'status'        => $request->get('status'),
            'user_id'       => Auth::id(),
            'country_id'    => $request->get('country_id')
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('cms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $countries = Country::where('status', true)->get();
        $hey =  CmsPage::with('country')->where('id', $id)->first();

        return Inertia::render('CMS::Pages/Edit', [
            'hey' => $hey,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'description' => 'required|string',
                'route' => 'required',
            ],
            [
                'description.required' => 'el campo descripción es obligatorio',
                'description.string' => 'el campo descripción solo acepta letras',
                'route.required' => 'el campo ruta es obligatorio',
            ]
        );

        CmsPage::find($id)->update([
            'description'   => $request->get('description'),
            'icon'          => $request->get('icon'),
            'route'         => $request->get('route'),
            'main'          => $request->get('main'),
            'status'        => $request->get('status'),
            'user_id'       => Auth::id(),
            'country_id'    => $request->get('country_id')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            // Verificamos si existe.
            $page = CmsPage::findOrFail($id);

            // Verificamos si hay detalles asociados
            // if ($page->detalles()->exists()) {
            //     $message =  'No se puede eliminar la pagina porque tiene detalles asociados.';
            //     $success = false;
            // }

            // Si no hay detalles asociados, eliminamos.
            $page->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Pagina eliminada correctamente';
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
