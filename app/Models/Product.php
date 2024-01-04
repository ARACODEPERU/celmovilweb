<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\SaleProductBrand;
use Modules\Sales\Entities\SaleProductCategory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'usine',
        'interne',
        'description',
        'image',
        'purchase_prices',
        'sale_prices',
        'sizes',
        'stock_min',
        'stock',
        'presentations',
        'is_product',
        'type_sale_affectation_id',
        'type_purchase_affectation_id',
        'type_unit_measure_id',
        'status',
        'category_id',
        'brand_id',
        'icbper'
    ];

    public function getImageAttribute($value)
    {
        return ($value != 'img/imagen-no-disponible.jpg' ? asset('storage/' . $value) : asset($value));
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(SaleProductCategory::class, 'category_id');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(SaleProductBrand::class, 'brand_id');
    }
}
