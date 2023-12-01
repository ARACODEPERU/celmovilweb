<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsItemType extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsItemTypeFactory::new();
    }
}
