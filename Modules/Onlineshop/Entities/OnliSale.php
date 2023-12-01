<?php

namespace Modules\Onlineshop\Entities;

use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OnliSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_name',
        'person_id',
        'total',
        'transaction_amount',
        'installments',
        'email',
        'clie_full_name',
        'identification_type',
        'identification_number',
        'token',
        'response_status',
        'response_status_detail',
        'response_id',
        'response_date_approved',
        'response_payer',
        'response_payment_method_id',
        'response_credit_card',
        'response_refunds'
    ];

    protected static function newFactory()
    {
        return \Modules\Onlineshop\Database\factories\OnliSaleFactory::new();
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
    public function details(): HasMany
    {
        return $this->hasMany(OnliSaleDetail::class, 'sale_id');
    }
}
