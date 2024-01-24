<?php

namespace Modules\Onlineshop\Entities;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OnliItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'entitie',
        'category_description',
        'name',
        'description',
        'scor',
        'price',
        'discount',
        'image',
        'status',
        'additional',
        'additional1',
        'additional2',
        'additional3',
        'additional4',
        'additional5'
    ];

    protected static function newFactory()
    {
        return \Modules\Onlineshop\Database\factories\OnliItemFactory::new();
    }

    public function getImageAttribute($value)
    {
        return ($value ? asset('storage/' . $value) : asset($value));
    }
    public function images(): HasMany
    {
        return $this->hasMany(OnliItemImage::class, 'item_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'item_id');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(OnliItemSpecification::class, 'onli_item_id');
    }
}
