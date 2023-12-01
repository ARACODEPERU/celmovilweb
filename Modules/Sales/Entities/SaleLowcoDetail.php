<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleLowcoDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'lowco_id',
        'model_name',
        'invoice_type_doc',
        'invoice_serie',
        'invoice_document_name',
        'invoice_correlative',
        'invoice_description'
    ];

    protected static function newFactory()
    {
        return \Modules\Sales\Database\factories\SaleLowcoDetailFactory::new();
    }
}
