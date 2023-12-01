<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Academic\Entities\AcaAgreement;

class AcaAgreementController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $agreements = AcaAgreement::with('institution')
            ->where('course_id', $id)
            ->get();

        return response()->json([
            'agreements' => $agreements
        ]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'course_id' => 'required',
                'institution_id' => [
                    'required',
                    'unique:aca_agreements,institution_id,NULL,id,course_id,' . $request->input('course_id'),
                ],
                'start_date' => 'required',
                'end_date' => 'required'
            ]
        );

        AcaAgreement::create([
            'course_id'     => $request->get('course_id'),
            'institution_id' => $request->get('institution_id'),
            'start_date'    => $request->get('start_date'),
            'end_date'      => $request->get('end_date'),
            'status'        => true
        ]);

        return response()->json([
            'success' => true
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
            $item = AcaAgreement::findOrFail($id);

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
