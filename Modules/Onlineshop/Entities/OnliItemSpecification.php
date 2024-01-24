<?php

namespace Modules\Onlineshop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Onlineshop\Database\factories\OnliItemSpecificationFactory;

class OnliItemSpecification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'onli_item_id',
        'product_id',
        'title',
        'description',
        'additonial'
    ];

    protected static function newFactory(): OnliItemSpecificationFactory
    {
        //return OnliItemSpecificationFactory::new();
    }
}
