<?php

namespace Modules\Health\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealCie10 extends Model
{
    use HasFactory;

    protected $fillable = [
        'cie10x',
        'cie10',
        'description'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Health\Database\factories\HealCie10Factory::new();
    }
}
