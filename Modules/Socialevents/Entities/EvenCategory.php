<?php

namespace Modules\Socialevents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Socialevents\Database\factories\EvenCategoryFactory;

class EvenCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'icon',
        'description',
        'status',
    ];

    protected static function newFactory(): EvenCategoryFactory
    {
        //return EvenCategoryFactory::new();
    }
}
