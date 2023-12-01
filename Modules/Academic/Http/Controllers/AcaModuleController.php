<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Academic\Entities\AcaModule;
use Modules\Academic\Entities\AcaTheme;

class AcaModuleController extends Controller
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

        $module = AcaModule::create([
            'course_id'     => $request->get('course_id'),
            'position'      => $request->get('position'),
            'description'   => $request->get('description')
        ]);

        return response()->json([
            'module' => $module
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

        $module = AcaModule::find($id);

        $module->update([
            'position'      => $request->get('position'),
            'description'   => $request->get('description')
        ]);

        return response()->json([
            'module' => $module
        ]);
    }


    public function destroy($id)
    {
        $message = null;
        $success = false;

        try {

            DB::beginTransaction();

            $item = AcaModule::findOrFail($id);

            $item->delete();

            DB::commit();

            $message =  'Modulo eliminada correctamente';
            $success = true;
        } catch (\Exception $e) {

            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    public function getThemeByModelId($id)
    {
        $themes = AcaTheme::with('contents')->where('module_id', $id)->get();
        return response()->json(['themes' => $themes]);
    }
}
