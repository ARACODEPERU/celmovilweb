<?php

namespace Modules\Restaurant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Restaurant\Database\factories\ResCategoryFactory;

class ResCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'icon', 'description', 'status', 'category_id'
    ];

    protected static function newFactory(): ResCategoryFactory
    {
        //return ResCategoryFactory::new();
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(ResCategoryPresentation::class, 'category_id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(ResCategory::class, 'category_id');
    }

    public function comandas(): HasMany
    {
        return $this->hasMany(ResComanda::class, 'category_id');
    }
}
