<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcaTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'position', 'description', 'module_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaThemeFactory::new();
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(AcaModule::class, 'module_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(AcaContent::class, 'theme_id');
    }
}
