<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sales\Database\factories\SaleProductCategoryFactory;

class SaleProductCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'description', 'category_id', 'image', 'status'
    ];

    protected static function newFactory(): SaleProductCategoryFactory
    {
        //return SaleProductCategoryFactory::new();
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(SaleProductCategory::class, 'category_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SaleProductCategory::class, 'category_id', 'id');
    }
}
