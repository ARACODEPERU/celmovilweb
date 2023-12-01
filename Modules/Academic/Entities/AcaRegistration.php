<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'course_id', 'status', 'modality_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaRegistrationFactory::new();
    }
}
