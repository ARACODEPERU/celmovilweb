<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sales\Entities\SalePhysicalDocument;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'local_id',
        'total',
        'advancement',
        'total_discount',
        'payments',
        'petty_cash_id',
        'status',
        'sale_date',
        'physical'
    ];

    public function saleProduct(): HasMany
    {
        return $this->hasMany(SaleProduct::class, 'sale_id', 'id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SaleDocument::class, 'sale_id', 'id');
    }

    public function physical(): HasMany
    {
        return $this->hasMany(SalePhysicalDocument::class, 'sale_id', 'id');
    }
}
