<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'position', 'description', 'content', 'theme_id', 'is_file'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaContentFactory::new();
    }
    public function getContentAttribute($value)
    {
        return html_entity_decode($value, ENT_QUOTES, "UTF-8");
    }
}
