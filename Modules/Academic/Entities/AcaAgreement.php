<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcaAgreement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_id', 'institution_id', 'start_date', 'end_date', 'status'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaAgreementFactory::new();
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AcaCourse::class, 'course_id', 'id');
    }
    public function institution(): BelongsTo
    {
        return $this->belongsTo(AcaInstitution::class, 'institution_id', 'id');
    }
}
