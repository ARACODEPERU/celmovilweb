<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'component_id'
    ];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsSectionFactory::new();
    }

    public function items(): HasMany
    {
        return $this->hasMany(CmsSectionItem::class, 'section_id', 'id');
    }
}
