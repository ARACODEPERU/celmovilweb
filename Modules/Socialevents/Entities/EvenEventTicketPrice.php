<?php

namespace Modules\Socialevents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Socialevents\Database\factories\EvenEventTickePriceFactory;

class EvenEventTicketPrice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'event_id', 'type_id', 'price', 'quantity', 'tickets_available'
    ];

    protected static function newFactory(): EvenEventTickePriceFactory
    {
        //return EvenEventTickePriceFactory::new();
    }

    public function type(): HasOne
    {
        return $this->hasOne(EvenTicketType::class, 'id', 'type_id');
    }
}
