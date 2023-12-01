<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LocalSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'address',
        'phone',
        'ubigeo',
        'sunat_code',
        'map',
        'agent',
        'email',
        'image'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function series()
    {
        return $this->hasMany(Serie::class, 'local_id');
    }

    public function district(): HasOne
    {
        return $this->hasOne(District::class, 'id', 'ubigeo');
    }
}
