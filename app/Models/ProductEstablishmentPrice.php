<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEstablishmentPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'local_id',
        'high',
        'under',
        'medium'
    ];
}
