<?php

namespace Modules\Socialevents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Socialevents\Database\factories\EvenEventTickeClientFactory;

class EvenEventTicketClient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_price_id',
        'full_name',
        'identification_number',
        'phone',
        'email',
        'ubigeo',
        'name_city',
        'quantity',
        'status'
    ];

    protected static function newFactory(): EvenEventTickeClientFactory
    {
        //return EvenEventTickeClientFactory::new();
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(EvenEvent::class, 'event_id');
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(EvenEventTicketPrice::class, 'ticket_price_id');
    }
}
