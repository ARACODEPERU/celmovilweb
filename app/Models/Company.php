<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'name',
        'business_name',
        'tradename',
        'fiscal_address',
        'phone',
        'representative',
        'email',
        'logo',
        'logo_document',
        'key_sunat',
        'user_sunat',
        'certificate_sunat',
        'mode',
        'ubigeo',
        'logo_negative',
        'logo_dark',
        'isotipo',
        'isotipo_negative',
        'isotipo_dark'
    ];

    public function district(): HasOne
    {
        return $this->hasOne(District::class, 'id', 'ubigeo');
    }
}
