<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'item_id',
        'position',
        'content',
        'description'
    ];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsItemFactory::new();
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(CmsItem::class, 'item_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CmsItem::class, 'item_id');
    }
}
