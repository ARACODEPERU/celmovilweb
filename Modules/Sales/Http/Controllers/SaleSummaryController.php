<?php

namespace Modules\Sales\Http\Controllers;

use App\Helpers\Invoice\Documents\Resumen;
use App\Models\SaleDocument;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Sales\Entities\SaleSummary;
use Modules\Sales\Entities\SaleSummaryDetail;

class SaleSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $summaries = (new SaleSummary())->newQuery();
        if (request()->has('search')) {
            $summaries->whereDate('summary_date', '=', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $summaries->orderBy($attribute, $sort_order);
        } else {
            $summaries->latest();
        }

        $summaries = $summaries->paginate(10)->onEachSide(2);

        return Inertia::render('Sales::Documents/Summary', [
            'summaries' => $summaries,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $documents = $request->get('documents');
        $generation_date = $request->get('generation_date');
        $result = array();

        $summary = SaleSummary::create([
            'generation_date'   => $generation_date . ' ' . Carbon::now()->format('H:i:s'),
            'summary_date'      => Carbon::now()->format('Y-m-d H:i:s'),
            'status'            => 'registrado'
        ]);

        foreach ($documents as $document) {
            SaleSummaryDetail::create([
                'document_id'               => $document['id'],
                'summary_id'                => $summary->id,
                'model_name'                => SaleDocument::class,
                'invoice_type_doc'          => $document['invoice_type_doc'],
                'invoice_serie'             => $document['invoice_serie'],
                'invoice_document_name'     => $document['invoice_serie'] . '-' . $document['number'],
                'invoice_correlative'       => $document['invoice_correlative'],
                'status'                    => $document['status'],
                'total'                     => $document['invoice_mto_imp_sale']
            ]);
            SaleDocument::where('id', $document['id'])
                ->update(['invoice_status' => 'Enviada']);
        }

        $factura = new Resumen();
        $result = $factura->create($summary, $documents);


        return response()->json([
            'success' => $result['success'],
            'code'  => $result['code'],
            'message'   => $result['message'],
            'notes'   => $result['notes']
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function searchDocuments($date)
    {
        $success = false;
        $documents = SaleDocument::select(
            'sale_documents.*',
            DB::raw('(SELECT description FROM sale_document_types WHERE sunat_id=invoice_type_doc) AS type_description')
        )
            ->whereDate('invoice_broadcast_date', $date)
            ->whereIn('invoice_type_doc', ['03', '07'])
            ->where('invoice_status', 'Pendiente')
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

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function checkSummary($id, $ticket)
    {
        $summary = new Resumen();
        $result = $summary->checkSummary($id, $ticket);

        return response()->json([
            'success' => $result['success'],
            'code'  => $result['code'],
            'message'   => $result['message'],
            'notes'   => $result['notes']
        ]);
    }

    public function destroySummary($id)
    {
        try {
            $summary = SaleSummary::find($id);
            $documents = SaleDocument::join('sale_summary_details', 'document_id', 'sale_documents.id')
                ->select('sale_documents.*')
                ->where('summary_id', $summary->id)
                ->get();
            foreach ($documents as $document) {
                SaleDocument::where('id', $document['id'])
                    ->update([
                        'invoice_status' => 'Pendiente',
                        'invoice_response_code' => 0,
                        'invoice_response_description' => null
                    ]);
            }

            $summary->delete();

            return array(
                'success' => true,
                'message' => 'resumen eliminado'
            );
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}
