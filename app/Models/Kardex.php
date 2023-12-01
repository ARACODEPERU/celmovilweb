<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_of_issue',
        'motion',
        'product_id',
        'local_id',
        'quantity',
        'document_id',
        'document_entity',
        'description'
    ];
}
