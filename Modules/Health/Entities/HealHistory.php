<?php

namespace Modules\Health\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'history_code'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Health\Database\factories\HealHistoryFactory::new();
    }
}
