<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CmsPageSection extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'section_id', 'description'];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsPageSectionFactory::new();
    }
    public function sections(): HasOne
    {
        return $this->hasOne(CmsSection::class, 'id', 'section_id');
    }
}
