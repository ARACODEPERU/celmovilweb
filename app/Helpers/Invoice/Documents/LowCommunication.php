<?php

namespace App\Helpers\Invoice\Documents;


use App\Helpers\Invoice\Util;
use DateTime;
use App\Models\Company as MyCompany;
use App\Models\SaleDocument;

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Modules\Sales\Entities\SaleLowcoDetail;
use Modules\Sales\Entities\SaleLowCommunication;


class LowCommunication
{
    protected $see;
    protected $util;
    protected $mycompany;

    public function __construct()
    {
        $this->util = Util::getInstance();
        $this->mycompany = MyCompany::first();
    }
    public function create($voided, $documents)
    {
        try {
            $sum = $this->createVoided($voided, $documents);
            // Envio a SUNAT.
            $see = $this->util->getSee();
            $res = $see->send($sum);

            $voided->xml = $this->util->writeXml($sum, $see->getFactory()->getLastXml());
            $voided->communication_name = $sum->getName();

            $notes = null;
            $status = null;
            $codeError = null;
            $messageError = null;

            if ($res->isSuccess()) {

                $ticket = $res->getTicket();
                $status = 'Enviado';
                $voided->ticket = $ticket;
            } else {

                $error = $res->getError();
                $codeError = $error->getCode();
                $messageError = $error->getMessage();
                $status = 'Rechazado';
                //return array('success' => $res->isSuccess(), 'details' => $this->util->getErrorResponse($res->getError()));

            }
            $voided->response_code = $codeError;
            $voided->response_description = $messageError;
            $voided->notes = $notes;
            $voided->status = $status;

            $voided->save();

            return array('success' => $res->isSuccess(), 'code' => $codeError, 'message' => $messageError, 'notes' => $notes);
        } catch (\Exception $e) {
            return array('success' => false, 'code' => 0, 'message' => $e->getMessage(), 'notes' => 'Error de falta de datos en el sistema');
        }
    }

    public function checkLowCommunication($id, $ticket)
    {
        try {
            $voided = SaleLowCommunication::find($id);
            $documents = SaleLowcoDetail::where('lowco_id', $id)
                ->get()
                ->toArray();

            $see = $this->util->getSee();
            $sum = $this->createVoided($voided, $documents, true);

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
                    SaleDocument::where('id', $document['document_id'])
                        ->update([
                            'invoice_status' => 'Anulada',
                            'invoice_response_code' => 0,
                            'invoice_response_description' => 'Comunicacion de baja ' . $voided->communication_name . ' Número ticket: ' . $ticket
                        ]);
                }
                $status = $cdr->getCode() == 0 ? 'Aceptado' : null;
                $voided->cdr = $this->util->writeCdr($sum, $res->getCdrZip());
            }

            $voided->response_code = $codeError;
            $voided->response_description = $codeError == '0127' ? 'El ticket no existe' : $messageError;
            $voided->notes = $notes;
            $voided->status = $status;
            $voided->save();

            return array('success' => $res->isSuccess(), 'code' => $codeError, 'message' => $messageError, 'notes' => $notes);
        } catch (\Exception $e) {
            return array('success' => false, 'code' => 0, 'message' => $e->getMessage(), 'notes' => 'Error de falta de datos en el sistema');
        }
    }

    public function createVoided($low, $documents, $ticket = false)
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
            $detail = new VoidedDetail();
            if ($ticket === false) {
                if ($document['edit_low']) {
                    switch ($document['invoice_type_doc']) {
                        case '01':
                            $detail->setTipoDoc($document['invoice_type_doc'])
                                ->setSerie($document['invoice_serie'])
                                ->setCorrelativo($document['invoice_correlative'])
                                ->setDesMotivoBaja($document['description_low']);
                            break;
                        case 1:
                            echo "i es igual a 1";
                            break;
                        case 2:
                            echo "i es igual a 2";
                            break;
                    }
                    array_push($items, $detail);
                }
            } else {
                switch ($document['invoice_type_doc']) {
                    case '01':
                        $detail->setTipoDoc($document['invoice_type_doc'])
                            ->setSerie($document['invoice_serie'])
                            ->setCorrelativo($document['invoice_correlative'])
                            ->setDesMotivoBaja($document['invoice_description']);
                        break;
                    case 1:
                        echo "i es igual a 1";
                        break;
                    case 2:
                        echo "i es igual a 2";
                        break;
                }
                array_push($items, $detail);
            }
        }

        // Fecha Generacion menor que Fecha Resumen
        $generation_date = new DateTime($low->generation_date);
        $communication_date = new DateTime($low->communication_date);

        $voided = new Voided();
        $voided->setCorrelativo($low->correlative)
            // Fecha Generacion menor que Fecha comunicacion
            ->setFecGeneracion($generation_date)
            ->setFecComunicacion($communication_date)
            ->setCompany($company)
            ->setDetails($items);

        return $voided;
    }
}
