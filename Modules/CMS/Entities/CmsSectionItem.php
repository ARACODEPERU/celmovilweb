<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsSectionItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'section_id', 'position', 'description'];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsSectionItemFactory::new();
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(CmsItem::class, 'item_id', 'id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(CmsItem::class, 'item_id', 'id');
    }
}
