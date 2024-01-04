<?php

namespace Modules\Onlineshop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Onlineshop\Database\factories\OnliItemImageFactory;

class OnliItemImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'item_id',
        'image_path',
        'image_name',
        'image_extension'
    ];

    protected static function newFactory(): OnliItemImageFactory
    {
        //return OnliItemImageFactory::new();
    }
}
