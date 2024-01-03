<?php

namespace Modules\Purchases\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurcDocumentItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'date_of_due',
        'affectation_igv_type_id',
        'price_type_id',
        'quantity',
        'unit_value',
        'total_base_igv',
        'percentage_igv',
        'total_igv',
        'total_base_isc',
        'percentage_isc',
        'total_isc',
        'total_base_other_taxes',
        'percentage_other_taxes',
        'total_other_taxes',
        'total_taxes',
        'unit_price',
        'total_value',
        'total_charge',
        'total_discount',
        'total',
        'discounts',
        'size'
    ];

    protected static function newFactory()
    {
        return \Modules\Purchases\Database\factories\PurcDocumentItemsFactory::new();
    }
}
