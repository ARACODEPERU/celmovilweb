<?php

namespace Modules\Sales\Http\Controllers;

use App\Helpers\Invoice\Documents\LowCommunication;
use App\Models\SaleDocument;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Sales\Entities\SaleLowCommunication;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sales\Entities\SaleLowcoDetail;

class SaleLowCommunicationController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $communications = (new SaleLowCommunication())->newQuery();
        if (request()->has('search')) {
            $communications->whereDate('communication_date', '=', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $communications->orderBy($attribute, $sort_order);
        } else {
            $communications->latest();
        }

        $communications = $communications->paginate(10)->onEachSide(2);

        return Inertia::render('Sales::Documents/LowCommunication', [
            'communications' => $communications,
            'filters' => request()->all('search'),
        ]);
    }

    public function searchDocuments($date)
    {
        $success = false;
        $documents = SaleDocument::select(
            'sale_documents.*',
            DB::raw('false AS edit_low'),
            DB::raw('"" AS description_low'),
            DB::raw('(SELECT description FROM sale_document_types WHERE sunat_id=invoice_type_doc) AS type_description')
        )
            ->whereDate('invoice_broadcast_date', $date)
            ->whereIn('invoice_type_doc', ['01', '07'])
            ->get();

        if (count($documents) > 0) {
            $success = true;
        } else {
            $success = false;
        }

        return response()->json([
            'success'   => $success,
            'documents' => $documents
        ]);
    }

    public function store(Request $request)
    {

        $documents = $request->get('documents');

        $this->validate($request, [
            'documents.*.description_low' => 'required_if:documents.*.edit_low,true',
        ], [
            'documents.*.description_low.required_if' => 'Ingrese el motivo de la baja del documento.',
        ]);

        $generation_date = $request->get('searchDate');
        $result = array();

        $lowco = SaleLowCommunication::create([
            'generation_date'       => $generation_date . ' ' . Carbon::now()->format('H:i:s'),
            'communication_date'    => Carbon::now()->format('Y-m-d H:i:s'),
            'status'                => 'registrado'
        ]);

        foreach ($documents as $document) {
            if ($document['edit_low']) {
                SaleLowcoDetail::create([
                    'document_id'  => $document['id'],
                    'lowco_id' => $lowco->id,
                    'model_name' => SaleDocument::class,
                    'invoice_type_doc' => $document['invoice_type_doc'],
                    'invoice_serie' => $document['invoice_serie'],
                    'invoice_document_name' => $document['invoice_serie'] . '-' . $document['number'],
                    'invoice_correlative' => $document['invoice_correlative'],
                    'invoice_description' => $document['description_low']
                ]);

                SaleDocument::where('id', $document['id'])
                    ->update([
                        'status'            => 3,
                        'invoice_status'    => 'Enviada Por Anular'
                    ]);
            }
        }

        $voided = new LowCommunication();
        $result = $voided->create($lowco, $documents);

        return response()->json([
            'success' => $result['success'],
            'code'  => $result['code'],
            'message'   => $result['message'],
            'notes'   => $result['notes']
        ]);
    }

    public function check($id, $ticket)
    {
        $voided = new LowCommunication();
        $result = $voided->checkLowCommunication($id, $ticket);

        return response()->json([
            'success' => $result['success'],
            'code'  => $result['code'],
            'message'   => $result['message'],
            'notes'   => $result['notes']
        ]);
    }
    public function destroy($id)
    {
        try {
            $low = SaleLowCommunication::find($id);
            $documents = SaleDocument::join('sale_lowco_details', 'document_id', 'sale_documents.id')
                ->select('sale_documents.*')
                ->where('lowco_id', $low->id)
                ->get();
            foreach ($documents as $document) {
                SaleDocument::where('id', $document['id'])
                    ->update([
                        'status'                        => 1,
                        'invoice_status'                => 'por anular',
                        'invoice_response_code'         => 0,
                        'invoice_response_description'  => null
                    ]);
            }

            $low->delete();

            return array(
                'success' => true,
                'message' => 'resumen eliminado'
            );
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}
