<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Academic\Entities\AcaContent;

class AcaContentController extends Controller
{
    use ValidatesRequests;

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'theme_id' => 'required',
                'position' => 'required',
                'description' => 'required',
                'content' => 'required'
            ]
        );

        $content = AcaContent::create([
            'theme_id'      => $request->get('theme_id'),
            'position'      => $request->get('position'),
            'description'   => $request->get('description'),
            'content'       => htmlentities($request->get('content'), ENT_QUOTES, "UTF-8"),
            'is_file'       => $request->get('is_file')
        ]);

        return response()->json(['success' => true, 'content' => $content]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'position' => 'required',
                'description' => 'required',
                'content' => 'required'
            ]
        );

        AcaContent::find($id)->update([
            'position'      => $request->get('position'),
            'description'   => $request->get('description'),
            'content'       => htmlentities($request->get('content'), ENT_QUOTES, "UTF-8"),
            'is_file'       => $request->get('is_file')
        ]);

        return response()->json(['success' => true]);
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

            $content = AcaContent::findOrFail($id);

            $content->delete();

            DB::commit();

            $message =  'Contenido eliminado correctamente';
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
