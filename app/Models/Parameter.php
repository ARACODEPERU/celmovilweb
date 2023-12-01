<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_code',
        'description',
        'control_type',
        'json_query_data',
        'value_default'
    ];
}
