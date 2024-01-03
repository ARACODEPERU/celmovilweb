<?php

namespace Modules\Restaurant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Restaurant\Database\factories\ResCategoryPresentationFactory;

class ResCategoryPresentation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'presentation_id'
    ];

    protected static function newFactory(): ResCategoryPresentationFactory
    {
        //return ResCategoryPresentationFactory::new();
    }
    public function presentation(): HasOne
    {
        return $this->hasOne(ResPresentation::class, 'id', 'presentation_id');
    }
}
