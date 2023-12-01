<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'serie_id',
        'number',
        'status',
        'client_type_doc',
        'client_number',
        'client_rzn_social',
        'client_address',
        'client_ubigeo_code',
        'client_ubigeo_description',
        'client_phone',
        'client_email',
        'invoice_document_name',
        'invoice_ubl_version',
        'invoice_type_operation',
        'invoice_type_doc',
        'invoice_serie',
        'invoice_correlative',
        'invoice_type_currency',
        'invoice_broadcast_date',
        'invoice_due_date',
        'invoice_send_date',
        'invoice_mto_oper_taxed',
        'invoice_mto_igv',
        'invoice_icbper',
        'invoice_total_taxes',
        'invoice_value_sale',
        'invoice_subtotal',
        'invoice_rounding',
        'invoice_mto_imp_sale',
        'invoice_legend_code',
        'invoice_legend_description',
        'invoice_sunat_points',
        'invoice_cdr',
        'invoice_xml',
        'invoice_pdf',
        'invoice_response_code',
        'invoice_response_description',
        'invoice_notes',
        'invoice_status',
        'invoice_mto_discount',
        'invoice_json_discounts',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleDocumentItem::class, 'document_id', 'id');
    }
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
