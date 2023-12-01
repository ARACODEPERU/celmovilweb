<?php

namespace Modules\Academic\Entities;

use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AcaTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_code', 'person_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaTeacherFactory::new();
    }

    public function person(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }
    public function courses(): HasMany
    {
        return $this->hasMany(AcaTeacherCourse::class, 'teacher_id');
    }
}
