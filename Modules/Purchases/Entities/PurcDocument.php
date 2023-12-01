<?php

namespace Modules\Purchases\Entities;

use App\Models\Person;
use App\Models\SaleDocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurcDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_id',
        'local_id',
        'serie',
        'number',
        'document_type_id',
        'date_of_issue',
        'date_of_due',
        'currency_type_id',
        'descripction',
        'total_prepayment',
        'total_charge',
        'total_discount',
        'total_exportation',
        'total_free',
        'total_taxed',
        'total_unaffected',
        'total_exonerated',
        'total_igv',
        'total_base_isc',
        'total_isc',
        'total_base_other_taxes',
        'total_other_taxes',
        'total_taxes',
        'total_value',
        'total',
        'total_canceled',
        'legends'
    ];

    protected static function newFactory()
    {
        return \Modules\Purchases\Database\factories\PurcDocumentFactory::new();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(SaleDocumentType::class, 'document_type_id', 'id');
    }

    public function provider(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'provider_id');
    }
}
