<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KardexSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'kardex_id',
        'product_id',
        'local_id',
        'size',
        'quantity'
    ];
}
