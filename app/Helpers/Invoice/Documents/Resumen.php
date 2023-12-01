<?php

namespace App\Helpers\Invoice\Documents;


use App\Helpers\Invoice\Util;
use Carbon\Carbon;
use DateTime;
use App\Models\Company as MyCompany;
use App\Models\SaleDocument;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Modules\Sales\Entities\SaleSummary;

class Resumen
{
    protected $see;
    protected $util;
    protected $mycompany;

    public function __construct()
    {
        $this->util = Util::getInstance();
        $this->mycompany = MyCompany::first();
    }
    public function create($summary, $documents)
    {
        try {
            $sum = $this->createSum($summary, $documents);
            // Envio a SUNAT.
            $see = $this->util->getSee();
            $res = $see->send($sum);

            $summary->xml = $this->util->writeXml($sum, $see->getFactory()->getLastXml());
            $summary->summary_name = $sum->getName();

            $notes = null;
            $status = null;
            $codeError = null;
            $messageError = null;

            if ($res->isSuccess()) {

                $ticket = $res->getTicket();
                $status = 'Enviado';
                $summary->ticket = $ticket;
            } else {

                $error = $res->getError();
                $codeError = $error->getCode();
                $messageError = $error->getMessage();
                $status = 'Rechazado';
                //return array('success' => $res->isSuccess(), 'details' => $this->util->getErrorResponse($res->getError()));

            }
            $summary->response_code = $codeError;
            $summary->response_description = $messageError;
            $summary->notes = $notes;
            $summary->status = $status;

            $summary->save();

            return array('success' => $res->isSuccess(), 'code' => $codeError, 'message' => $messageError, 'notes' => $notes);
        } catch (\Exception $e) {
            return array('success' => false, 'code' => 0, 'message' => $e->getMessage(), 'notes' => 'Error de falta de datos en el sistema');
        }
    }

    public function checkSummary($id, $ticket)
    {
        try {
            $summary = SaleSummary::find($id);
            $documents = SaleDocument::join('sale_summary_details', 'document_id', 'sale_documents.id')
                ->select('sale_documents.*')
                ->where('summary_id', $id)
                ->get()
                ->toArray();

            $see = $this->util->getSee();
            $sum = $this->createSum($summary, $documents);

            $notes = null;
            $status = null;
            $codeError = null;
            $messageError = null;

            $res = $see->getStatus($ticket);
            if (!$res->isSuccess()) {
                $error = $res->getError();
                $codeError = $error->getCode();
                $messageError = $error->getMessage();
                $status = 'Rechazado';
            } else {
                $cdr = $res->getCdrResponse();
                $codeError = $cdr->getCode();
                $messageError = $cdr->getDescription();
                if ($cdr->getNotes()) {
                    $notes = json_encode($cdr->getNotes(), JSON_UNESCAPED_UNICODE);
                }
                foreach ($documents as $document) {
                    SaleDocument::where('id', $document['id'])
                        ->update([
                            'invoice_status' => 'Aceptada',
                            'invoice_response_code' => 0,
                            'invoice_response_description' => 'Emviado en resumen ' . $summary->summary_name . ' Número ticket: ' . $ticket
                        ]);
                }
                $status = $cdr->getCode() == 0 ? 'Aceptado' : null;
                $summary->cdr = $this->util->writeCdr($sum, $res->getCdrZip());
            }

            $summary->response_code = $codeError;
            $summary->response_description = $codeError == '0127' ? 'El ticket no existe' : $messageError;
            $summary->notes = $notes;
            $summary->status = $status;
            $summary->save();

            return array('success' => $res->isSuccess(), 'code' => $codeError, 'message' => $messageError, 'notes' => $notes);
        } catch (\Exception $e) {
            return array('success' => false, 'code' => 0, 'message' => $e->getMessage(), 'notes' => 'Error de falta de datos en el sistema');
        }
    }

    public function createSum($summary, $documents)
    {
        $items = [];

        $company = new Company();

        $province = $this->mycompany->district->province;
        $department = $province->department;

        $company->setRuc($this->mycompany->ruc)
            ->setRazonSocial($this->mycompany->business_name)
            ->setNombreComercial($this->mycompany->tradename)
            ->setAddress((new Address())
                ->setUbigueo($this->mycompany->ubigeo)
                ->setDepartamento($department->name)
                ->setProvincia($province->name)
                ->setDistrito($this->mycompany->district->name)
                ->setUrbanizacion('-')
                ->setDireccion($this->mycompany->fiscal_address));

        foreach ($documents as $document) {
            $detiail = new SummaryDetail();
            if ($document['invoice_type_doc'] == '03') {
                $serie_number = $document['invoice_serie'] . '-' . $document['invoice_correlative'];
                ///estados de boleta 
                ///1= Se esta informando por primera vez. 
                ///2= Se informó previamente y se quiere editar sus valores.
                ///3= Se quiere anular el comprobante
                $detiail->setTipoDoc($document['invoice_type_doc'])
                    ->setSerieNro($serie_number)
                    ->setEstado($document['status'])
                    ->setClienteTipo($document['client_type_doc'])
                    ->setClienteNro($document['client_number'])
                    ->setTotal($document['invoice_mto_imp_sale'])
                    ->setMtoOperGravadas($document['invoice_mto_oper_taxed'])
                    ->setMtoOperInafectas($document['invoice_mto_oper_unaffected'])
                    ->setMtoOperExoneradas($document['invoice_mto_oper_exonerated'])
                    ->setMtoOperExportacion($document['invoice_mto_oper_export'])
                    ->setMtoOtrosCargos($document['invoice_mto_oper_other_charges'])
                    ->setMtoIGV($document['invoice_total_taxes']);
            }


            array_push($items, $detiail);
        }

        $sum = new Summary();
        // Fecha Generacion menor que Fecha Resumen
        $generation_date = new DateTime($summary->generation_date);
        $summary_date = new DateTime($summary->summary_date);
        $sum->setFecGeneracion($generation_date)
            ->setFecResumen($summary_date)
            ->setCorrelativo($summary->correlative)
            ->setCompany($company)
            ->setDetails($items);

        return $sum;
    }
}
