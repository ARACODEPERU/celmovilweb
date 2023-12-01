<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\CMS\Entities\CmsSection;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CmsSectionController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $sections = (new CmsSection())->newQuery();
        if (request()->has('search')) {
            $sections->where('description', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $sections->orderBy($attribute, $sort_order);
        } else {
            $sections->latest();
        }

        $sections = $sections->paginate(20)->onEachSide(2);

        return Inertia::render('CMS::Sections/List', [
            'sections' => $sections
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return Inertia::render('CMS::Sections/Create');
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
            ],
            [
                'description.required' => 'el campo descripción es obligatorio',
            ]
        );

        $section = CmsSection::create([
            'description'   => $request->get('description')
        ]);
        $description = $section->description;

        // Reemplazar letras acentuadas por letras sin acento
        $description = $this->eliminar_acentos($description);

        $section->component_id = $description . "_" . $section->id;
        $section->save();
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
        $section =  CmsSection::find($id);
        return Inertia::render('CMS::Sections/Edit', ['section' => $section]);
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
            ],
            [
                'description.required' => 'el campo descripción es obligatorio',
            ]
        );
        //este será el component_id
        $description = $request->get('description');

        // Reemplazar letras acentuadas por letras sin acento
        $description = $this->eliminar_acentos($description);

        CmsSection::find($id)->update([
            'description'   => $request->get('description'),
            'component_id'  => $description . "_" . $id,
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
            $section = CmsSection::findOrFail($id);

            // Verificamos si hay detalles asociados a este producto.
            // if ($page->detalles()->exists()) {
            //     $message =  'No se puede eliminar la pagina porque tiene detalles asociados.';
            //     $success = false;
            // }

            // Si no hay detalles asociados, eliminamos.
            $section->delete();

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

    public function eliminar_acentos($cadena)
    {

        // Reemplazar espacios por guiones bajos
        $cadena = str_replace(' ', '_', $cadena);

        // Convertir a minúsculas
        $cadena = strtolower($cadena);


        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
        $cadena = str_replace($no_permitidas, $permitidas, $cadena);
        // Eliminar caracteres especiales
        $cadena = preg_replace('/[^a-z0-9_]/i', '', $cadena);
        return $cadena;
    }
}
