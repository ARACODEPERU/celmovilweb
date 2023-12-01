<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcaTeacherCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'course_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaTeacherCourseFactory::new();
    }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(AcaTeacher::class, 'teacher_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AcaCourse::class, 'course_id');
    }
}
