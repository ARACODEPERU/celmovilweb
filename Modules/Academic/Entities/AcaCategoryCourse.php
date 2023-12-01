<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcaCategoryCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'capacitation', 'image'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaCategoryCourseFactory::new();
    }

    public function course(): HasMany
    {
        return $this->hasMany(AcaCourse::class);
    }
}
