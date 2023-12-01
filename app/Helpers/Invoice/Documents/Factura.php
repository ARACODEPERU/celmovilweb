<?php

namespace App\Helpers\Invoice\Documents;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Invoice;
use App\Models\SaleDocument;
use App\Helpers\Invoice\Util;
use Carbon\Carbon;
use DateTime;
use App\Models\Company as MyCompany;
use App\Models\LocalSale;
use Exception;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Charge;

class Factura
{
    protected $see;
    protected $util;
    protected $mycompany;

    public function __construct()
    {
        $this->util = Util::getInstance();
        $this->mycompany = MyCompany::first();
    }
    public function create($document_id)
    {
        try {
            $document = SaleDocument::find($document_id);
            $invoice = $this->setDocument($document);
            $see = $this->util->getSee();
            $res = $see->send($invoice);
            //fecha en la que se envio a sunat el documento
            $document->invoice_send_date = Carbon::now();

            $document->invoice_xml = $this->util->writeXml($invoice, $see->getFactory()->getLastXml());
            $document->invoice_document_name = $invoice->getName();
            $notes = null;
            $status = null;

            if ($res->isSuccess()) {
                /**@var $res \Greenter\Model\Response\BillResult*/
                $cdr = $res->getCdrResponse();
                $codeError = $cdr->getCode();
                $messageError = $cdr->getDescription();
                $notes = json_encode($cdr->getNotes(), JSON_UNESCAPED_UNICODE);
                $status = $cdr->getCode() == 0 ? 'Aceptada' : null;
                $document->invoice_cdr = $this->util->writeCdr($invoice, $res->getCdrZip());
            } else {
                $error = $res->getError();
                $codeError = $error->getCode();
                $messageError = $error->getMessage();
                $status = 'Rechazada';
                //return array('success' => $res->isSuccess(), 'details' => $this->util->getErrorResponse($res->getError()));

            }
            $document->invoice_response_code = $codeError;
            $document->invoice_response_description = $messageError;
            $document->invoice_notes = $notes;
            $document->invoice_status = $status;

            $document->save();

            return array('success' => $res->isSuccess(), 'code' => $codeError, 'message' => $messageError, 'notes' => $notes);
        } catch (\Exception $e) {
            return array('success' => false, 'code' => 0, 'message' => $e->getMessage(), 'notes' => 'Error de falta de datos en el sistema');
        }
    }

    public function setDocument($document)
    {
        $establishment = LocalSale::find($document->sale->local_id);
        $province = $establishment->district->province;

        $department = $province->department;
        $broadcast_date = new DateTime($document->invoice_broadcast_date . ' ' . Carbon::parse($document->created_at)->format('H:m:s'));
        // Cliente
        $client = (new Client())
            ->setTipoDoc($document->client_type_doc)
            ->setNumDoc($document->client_number)
            ->setRznSocial($document->client_rzn_social);
        // Emisor
        $address = (new Address())
            ->setUbigueo($establishment->ubigeo)
            ->setDepartamento($department->name)
            ->setProvincia($province->name)
            ->setDistrito($establishment->district->name)
            ->setUrbanizacion('-')
            ->setDireccion($establishment->address)
            ->setCodLocal($establishment->sunat_code); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
        $company = (new Company())
            ->setRuc($this->mycompany->ruc)
            ->setRazonSocial($this->mycompany->business_name)
            ->setNombreComercial($this->mycompany->tradename)
            ->setAddress($address);

        // Venta
        $invoice = new Invoice();
        $invoice->setUblVersion($document->invoice_ubl_version)
            ->setTipoOperacion($document->invoice_type_operation)
            ->setTipoDoc($document->invoice_type_doc)
            ->setSerie($document->invoice_serie)
            ->setCorrelativo($document->invoice_correlative)
            ->setFechaEmision($broadcast_date)
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            ->setTipoMoneda('PEN')
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas($document->invoice_mto_oper_taxed)
            ->setMtoIGV($document->invoice_mto_igv)
            ->setTotalImpuestos($document->invoice_total_taxes)
            ->setValorVenta($document->invoice_value_sale)
            ->setSubTotal($document->invoice_subtotal)
            ->setMtoImpVenta($document->invoice_mto_imp_sale);

        $details = $document->items;
        $items = [];
        foreach ($details as $detail) {

            $item = new SaleDetail();

            $item->setCodProducto($detail->cod_product)
                ->setUnidad($detail->unit_type)
                ->setCantidad($detail->quantity)
                ->setDescripcion($detail->decription_product)
                ->setMtoBaseIgv($detail->mto_base_igv)
                ->setPorcentajeIgv($detail->percentage_igv)
                ->setIgv($detail->igv)
                ->setTipAfeIgv($detail->type_afe_igv)
                ->setTotalImpuestos($detail->total_tax)
                ->setMtoValorVenta($detail->mto_value_sale)
                ->setMtoValorUnitario($detail->mto_value_unit)
                ->setMtoPrecioUnitario($detail->mto_price_unit);

            $descuent = $detail->mto_discount;

            if ($descuent > 0) {
                $json_discounts = json_decode($detail->json_discounts);

                $charges = [];

                foreach ($json_discounts as $k => $json_discount) {
                    $charges[$k] = (new Charge())
                        ->setCodTipo($json_discount->type)
                        ->setMontoBase($json_discount->base)
                        ->setFactor($json_discount->factor)
                        ->setMonto($json_discount->monto);
                }

                $item->setDescuentos($charges);
            }

            array_push($items, $item);
        }

        $legend = new Legend();
        $legend->setCode($document->invoice_legend_code)
            ->setValue($document->invoice_legend_description);

        $invoice->setDetails($items)
            ->setLegends([$legend]);
        return $invoice;
    }

    public function getFacturaPdf($id)
    {
        try {
            $document = SaleDocument::find($id);
            $invoice = $this->setDocument($document);
            $pdf = $this->util->getPdf($invoice);
            $filePath = $this->util->showPdf($pdf, $invoice->getName() . '.pdf');
            $document->invoice_pdf = $filePath;
            $document->save();
            return array(
                'fileName' => $invoice->getName() . '.pdf',
                'filePath' => $filePath
            );
        } catch (Exception $e) {
            var_dump($e);
        }
    }
    public function getFacturaXML($id)
    {
        try {
            $document = SaleDocument::find($id);

            return array(
                'fileName' => $document->invoice_document_name . '.xml',
                'filePath' => $document->invoice_xml
            );
        } catch (Exception $e) {
            var_dump($e);
        }
    }
    public function getFacturaCDR($id)
    {
        try {
            $document = SaleDocument::find($id);

            return array(
                'fileName' => $document->invoice_document_name . '.zip',
                'filePath' => $document->invoice_cdr
            );
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}
