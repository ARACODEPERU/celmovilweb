<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDocumentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'sunat_id'
    ];
}
