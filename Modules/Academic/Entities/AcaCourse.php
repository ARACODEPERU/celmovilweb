<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AcaCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'description',
        'course_day',
        'course_month',
        'course_year',
        'category_id',
        'image',
        'modality_id',
        'type_description',
        'teacher_id',
        'sector_description'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaCourseFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AcaCategoryCourse::class, 'category_id');
    }
    public function modality(): BelongsTo
    {
        return $this->belongsTo(AcaModality::class, 'modality_id', 'id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(AcaModule::class, 'course_id');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(AcaTeacher::class, 'id', 'teacher_id');
    }

    public function brochure(): HasOne
    {
        return $this->hasOne(AcaBrochure::class, 'course_id');
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(AcaAgreement::class, 'course_id');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(AcaTeacherCourse::class, 'course_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(AcaCapRegistration::class, 'course_id');
    }
}
