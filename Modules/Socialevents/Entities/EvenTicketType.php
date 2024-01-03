<?php

namespace Modules\Socialevents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Socialevents\Database\factories\EvenTicketTypeFactory;

class EvenTicketType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'description'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function newFactory(): EvenTicketTypeFactory
    {
        //return EvenTicketTypeFactory::new();
    }
}
