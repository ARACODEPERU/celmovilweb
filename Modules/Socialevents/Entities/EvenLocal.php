<?php

namespace Modules\Socialevents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Socialevents\Database\factories\EvenLocalFactory;

class EvenLocal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'names',
        'address',
        'map_code',
        'image1',
        'image2',
        'image3',
        'image4',
        'maximum_capacity',
        'status',
        'ubigeo'
    ];

    protected static function newFactory(): EvenLocalFactory
    {
        //return EvenLocalFactory::new();
    }
}
