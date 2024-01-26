<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Sales\Database\factories\SaleProductBrandFactory;

class SaleProductBrand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['description', 'image', 'status'];

    protected static function newFactory(): SaleProductBrandFactory
    {
        //return SaleProductBrandFactory::new();
    }
}
