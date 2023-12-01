<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleSummaryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'summary_id',
        'model_name',
        'invoice_type_doc',
        'invoice_serie',
        'invoice_document_name',
        'invoice_correlative',
        'status',
        'total'
    ];

    protected static function newFactory()
    {
        return \Modules\Sales\Database\factories\SaleSummaryDetailFactory::new();
    }
}
