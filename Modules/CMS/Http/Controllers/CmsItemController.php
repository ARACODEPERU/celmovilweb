<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\CMS\Entities\CmsItem;
use Modules\CMS\Entities\CmsItemType;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

class CmsItemController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $types = CmsItemType::all();
        $items = (new CmsItem())->newQuery();
        if (request()->has('search')) {
            $items->where('description', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $items->orderBy($attribute, $sort_order);
        } else {
            $items->latest();
        }

        $items = $items->paginate(20)->onEachSide(2);

        return Inertia::render('CMS::Items/List', [
            'types' => $types,
            'items' => $items,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $types = CmsItemType::where('id', '<>', 5)->get();
        return inertia::render('CMS::Items/Create', ['types' => $types,]);
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
                'type_id' => 'required',
                'content' => 'required',
                'description' => 'required|max:255',
            ],
            [
                'type_id.required' => 'el campo Tipo es obligatorio',
                'content.required' => 'el campo Contenido es obligatorio',
                'description.required' => 'el campo Descripción es obligatorio',
            ]
        );

        $destination = 'uploads/cms/items';
        $type_id = $request->get('type_id');
        $content = null;
        if ($type_id == 1 || $type_id == 3) {
            $file = $request->file('content');
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('content')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $content = $type_id == 1 ? asset('storage/' . $path) : $path;
        }
        if ($type_id == 2 || $type_id == 4) {
            $content = $request->get('content');
        }
        CmsItem::create([
            'type_id' => $type_id,
            'position' => $request->get('position') ?? 0,
            'content' => $content,
            'description' => $request->get('description')
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $types = CmsItemType::where('id', '<>', 5)->get();
        $item = CmsItem::find($id);

        return inertia::render('CMS::Items/Edit', [
            'types' => $types,
            'item' => $item // Pasa la instancia del ítem que ahora contiene la ruta de la imagen
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {

        $id = $request->get('id');
        $this->validate(
            $request,
            [
                'type_id' => 'required',
                'content' => 'required',
                'description' => 'required|max:255',
            ],
            [
                'type_id.required' => 'el campo Tipo es obligatorio',
                'content.required' => 'el campo Contenido es obligatorio',
                'description.required' => 'el campo Descripción es obligatorio',
            ]
        );

        $destination = 'uploads/articles';
        $type_id = $request->get('type_id');
        $content = null;
        if ($type_id == 1 || $type_id == 3) {
            $file = $request->file('content');
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('content')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $content = $type_id == 1 ? asset('storage/' . $path) : $path;
        }
        if ($type_id == 2 || $type_id == 4) {
            $content = $request->get('content');
        }
        CmsItem::find($id)->update([
            'type_id' => $request->get('type_id'),
            'position' => $request->get('position') ?? 0,
            'content' => $content,
            'description' => $request->get('description')
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
            $item = CmsItem::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Item eliminado correctamente';
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
