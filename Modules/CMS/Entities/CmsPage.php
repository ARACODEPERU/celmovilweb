<?php

namespace Modules\CMS\Entities;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CmsPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'icon',
        'route',
        'main',
        'status',
        'user_id',
        'country_id'
    ];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsPageFactory::new();
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
