<?php

namespace Modules\Restaurant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Restaurant\Database\factories\ResSaleDetailFactory;

class ResSaleDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sale_id',
        'comanda_id',
        'quantity',
        'price',
        'discount'
    ];

    protected static function newFactory(): ResSaleDetailFactory
    {
        //return ResSaleDetailFactory::new();
    }
}
