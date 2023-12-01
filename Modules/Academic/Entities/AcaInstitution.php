<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Academic\Database\factories\AcaInstitutionFactory;

class AcaInstitution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'image',
        'phone',
        'address',
        'status'
    ];

    protected static function newFactory(): AcaInstitutionFactory
    {
        //return AcaInstitutionFactory::new();
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(AcaAgreement::class, 'institution_id');
    }
}
