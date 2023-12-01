<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AcaBrochure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_id',
        'resolution',
        'presentation',
        'benefits',
        'frequent_questions',
        'path_file'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaBrochureFactory::new();
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AcaCourse::class, 'course_id');
    }
}
