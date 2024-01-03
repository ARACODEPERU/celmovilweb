<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Sales\Database\factories\SaleProductCategoryFactory;

class SaleProductCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'description', 'category_id'
    ];

    protected static function newFactory(): SaleProductCategoryFactory
    {
        //return SaleProductCategoryFactory::new();
    }
}
