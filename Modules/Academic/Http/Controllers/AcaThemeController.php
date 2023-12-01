<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Academic\Entities\AcaTheme;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

class AcaThemeController extends Controller
{
    use ValidatesRequests;

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'position' => 'required',
                'description' => 'required|max:255'
            ]
        );

        $theme = AcaTheme::create([
            'module_id'     => $request->get('module_id'),
            'position'      => $request->get('position'),
            'description'   => $request->get('description')
        ]);

        return response()->json([
            'theme' => $theme
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'position' => 'required',
                'description' => 'required|max:255'
            ]
        );

        $theme = AcaTheme::find($id);

        $theme->update([
            'position'      => $request->get('position'),
            'description'   => $request->get('description')
        ]);

        return response()->json([
            'theme' => $theme
        ]);
    }

    public function destroy($id)
    {
        $message = null;
        $success = false;

        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            $theme = AcaTheme::findOrFail($id);

            $theme->delete();

            DB::commit();

            $message =  'Clase eliminada correctamente';
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
