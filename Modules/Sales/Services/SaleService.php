<?php

namespace Modules\Sales\Services;

use App\Helpers\NumberLetter;
use App\Models\Kardex;
use App\Models\KardexSize;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDocument;
use App\Models\SaleDocumentItem;
use App\Models\SaleDocumentType;
use App\Models\Serie;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected $igv;
    protected $ubl;

    public function __construct()
    {
        $this->igv = \App\Models\Parameter::where('parameter_code', 'P000001')->value('value_default');
        $this->ubl = \App\Models\Parameter::where('parameter_code', 'P000003')->value('value_default');
    }

    public function createSale($data, $user_id, $local_id)
    {
        $petty_cash = PettyCash::firstOrCreate([
            'user_id' => $user_id,
            'state' => 1,
            'local_sale_id' => $local_id
        ], [
            'date_opening' => Carbon::now()->format('Y-m-d'),
            'time_opening' => date('H:i:s'),
            'income' => 0
        ]);

        return Sale::create([
            'sale_date' => $data['date_issue'],
            'user_id' => $user_id,
            'client_id' => $data['client_id'],
            'local_id' => $local_id,
            'total' => $data['total'],
            'advancement' => $data['total'],
            'total_discount' => $data['total_discount'] ?? 0,
            'payments' => json_encode($data['payments']),
            'petty_cash_id' => $petty_cash->id,
            'physical' => 2
        ]);
    }

    public function createDocumentForSale(Sale $sale, $data, $items, $local_id)
    {
        $serie = Serie::find($data['serie']);
        $tido = SaleDocumentType::find($data['sale_documenttype_id']);
        $numberletters = new NumberLetter();

        $document = SaleDocument::create([
            'sale_id'                       => $sale->id,
            'serie_id'                      => $data['serie'],
            'number'                        => str_pad($serie->number, 9, '0', STR_PAD_LEFT),
            'status'                        => true,
            'client_type_doc'               => $data['client_dti'],
            'client_number'                 => $data['client_number'],
            'client_rzn_social'             => $data['client_rzn_social'],
            'client_address'                => $data['client_direction'] ?? ($data['client_address'] ?? ''),
            'client_ubigeo_code'            => $data['client_ubigeo'] ?? ($data['client_ubigeo_code'] ?? null),
            'client_ubigeo_description'     => $data['client_ubigeo_description'],
            'client_phone'                  => $data['client_phone'],
            'client_email'                  => $data['client_email'],
            'invoice_ubl_version'           => $this->ubl,
            'invoice_type_operation'        => $data['type_operation'],
            'invoice_type_doc'              => $tido->sunat_id,
            'invoice_serie'                 => $serie->description,
            'invoice_correlative'           => $serie->number,
            'invoice_type_currency'         => 'PEN',
            'invoice_broadcast_date'        => $data['date_issue'],
            'invoice_due_date'              => $data['date_end'],
            'invoice_send_date'             => Carbon::now()->format('Y-m-d'),
            'invoice_legend_code'           => '1000',
            'invoice_legend_description'    => $numberletters->convertToLetter($data['total']),
            'invoice_status'                => 'registrado'
        ]);

        $totals = $this->processItems($items, $document, $local_id);

        $document->update([
            'invoice_mto_oper_taxed'    => $totals['mto_oper_taxed'],
            'invoice_mto_igv'           => $totals['mto_igv'],
            'invoice_icbper'            => $totals['total_icbper'],
            'invoice_total_taxes'       => $totals['total_taxes'],
            'invoice_value_sale'        => $totals['mto_oper_taxed'],
            'invoice_subtotal'          => $totals['subtotal'],
            'invoice_rounding'          => $totals['rounding'],
            'invoice_mto_imp_sale'      => $totals['ttotal'],
            'invoice_sunat_points'      => null,
            'invoice_status'            => 'Pendiente',
        ]);

        $serie->increment('number', 1);

        return $document;
    }

    private function processItems($products, $document, $local_id)
    {
        $mto_oper_taxed = 0;
        $mto_igv = 0;
        $total_icbper = 0;
        $total = 0;

        foreach ($products as $produc) {
            $product_id = $produc['id'] ?? null;
            $interne = $produc['interne'] ?? null;

            if (!$product_id) {
                $randomNumberPadded = str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);
                $new_product = Product::create([
                    'usine' => $randomNumberPadded,
                    'interne' => $randomNumberPadded,
                    'description' => $produc['description'],
                    'image' => 'img/imagen-no-disponible.jpeg',
                    'purchase_prices' => 0,
                    'sale_prices' => json_encode(['high' => $produc['unit_price'], 'under' => null, 'medium' => null]),
                    'stock_min' => 1,
                    'stock' => $produc['quantity'],
                    'presentations' => false,
                    'is_product' => $produc['is_product'],
                    'type_sale_affectation_id' => '10',
                    'type_purchase_affectation_id' => '10',
                    'type_unit_measure_id' => $produc['is_product'] ? $produc['unit_type'] : 'ZZ',
                    'status' => true
                ]);
                $product_id = $new_product->id;
                $interne = $randomNumberPadded;

                if ($produc['is_product']) {
                    Kardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'motion' => 'purchase',
                        'product_id' => $new_product->id,
                        'local_id' => $local_id,
                        'quantity' => $produc['quantity'],
                        'description' => 'Stock Inicial',
                    ]);
                }
            }

            // Cálculos
            $nfactorIGV = round(($this->igv / 100) + 1, 2);
            $ifactorIGV = round($this->igv / 100, 2);
            $quantity = $produc['quantity'];
            $price_sale = $produc['unit_price'];
            
            $value_unit = 0;
            $igv = 0;
            $icbper = ($produc['icbper'] == 1) ? ($quantity * 0.20) : 0;
            $factor_icbper = ($produc['icbper'] == 1) ? 0.20 : 0;
            $value_sale = 0;
            $total_item = 0;
            $mto_discount = 0;
            $array_discounts = [];
            $unit_price = $price_sale;

            if ($produc['afe_igv'] == '10') {
                $value_unit = round($price_sale / $nfactorIGV, 2);
                $base = round($value_unit * $quantity, 2);
                $factor = (($produc['discount'] * 100) / $price_sale) / 100;
                $descuento_monto = $factor * $value_unit * $quantity;
                $mto_base_igv = ($value_unit * $quantity) - $descuento_monto;
                $igv = ($mto_base_igv * $ifactorIGV);
                $total_item = (($value_unit * $quantity) - $descuento_monto) + $igv;
                $value_sale = ($value_unit * $quantity) - $descuento_monto;

                if ($produc['discount'] > 0) {
                    $unit_price = round(($value_sale + $igv) / $quantity, 2);
                    $array_discounts[0] = [
                        'value' => $produc['discount'],
                        'type' => '00',
                        'base' => round($base, 2),
                        'factor' => $factor,
                        'monto' => round($descuento_monto, 2)
                    ];
                }
                $mto_discount = round($descuento_monto, 2);
            }

            SaleDocumentItem::create([
                'document_id' => $document->id,
                'product_id' => $product_id,
                'cod_product' => $interne,
                'decription_product' => $produc['description'],
                'unit_type' => $produc['unit_type'],
                'quantity' => $quantity,
                'mto_base_igv' => $mto_base_igv ?? 0,
                'percentage_igv' => $this->igv,
                'igv' => $igv,
                'total_tax' => $igv + $icbper,
                'type_afe_igv' => $produc['afe_igv'],
                'icbper' => $icbper,
                'factor_icbper' => $factor_icbper,
                'mto_value_sale' => $value_sale,
                'mto_value_unit' => $value_unit,
                'mto_price_unit' => $unit_price,
                'price_sale' => $price_sale,
                'mto_total' => round($total_item, 2),
                'mto_discount' => $mto_discount,
                'json_discounts' => json_encode($array_discounts)
            ]);

            if ($produc['is_product']) {
                $this->updateKardex($product_id, $quantity, $local_id, $document, $produc['size'] ?? null);
            }

            $mto_igv += $igv;
            $total_icbper += $icbper;
            $mto_oper_taxed += $value_sale;
            $total += $total_item;
        }

        $total_taxes = $mto_igv + $total_icbper;
        $subtotal = $total_taxes + $mto_oper_taxed;
        $ttotal = round($total, 1);
        
        return [
            'mto_oper_taxed' => $mto_oper_taxed,
            'mto_igv' => $mto_igv,
            'total_icbper' => $total_icbper,
            'total_taxes' => $total_taxes,
            'subtotal' => $subtotal,
            'rounding' => number_format(abs($ttotal - $subtotal), 2),
            'ttotal' => $ttotal
        ];
    }

    private function updateKardex($product_id, $quantity, $local_id, $document, $size)
    {
        $k = Kardex::create([
            'date_of_issue' => Carbon::now()->format('Y-m-d'),
            'motion' => 'sale',
            'product_id' => $product_id,
            'local_id' => $local_id,
            'quantity' => $quantity * (-1),
            'document_id' => $document->id,
            'document_entity' => SaleDocument::class,
            'description' => 'Venta'
        ]);

        $product = Product::find($product_id);
        if ($product->presentations && $size) {
            KardexSize::create([
                'kardex_id' => $k->id,
                'product_id' => $product_id,
                'local_id' => $local_id,
                'size' => $size,
                'quantity' => ($quantity * (-1))
            ]);
            
            $tallas = json_decode($product->sizes, true);
            foreach ($tallas as &$talla) {
                if ($talla['size'] == $size) {
                    $talla['quantity'] -= $quantity;
                }
            }
            $product->update(['sizes' => json_encode($tallas)]);
        }
        $product->decrement('stock', $quantity);
    }
}