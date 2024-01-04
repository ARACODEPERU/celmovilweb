<?php

namespace Modules\Onlineshop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'additional2'
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
}
