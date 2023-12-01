<?php

namespace Modules\Academic\Entities;

use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Academic\Database\factories\AcaTeachingResumeFactory;

class AcaTeachingResume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'teacher_id',
        'type',
        'description',
        'charge',
        'company',
        'start_date',
        'end_date',
        'person_id'
    ];

    protected static function newFactory(): AcaTeachingResumeFactory
    {
        //return AcaTeachingResumeFactory::new();
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
