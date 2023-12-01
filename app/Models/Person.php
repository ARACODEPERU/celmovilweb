<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Academic\Entities\AcaTeacher;
use Modules\Academic\Entities\AcaTeachingResume;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_name',
        'full_name',
        'description',
        'document_type_id',
        'number',
        'telephone',
        'email',
        'image',
        'address',
        'is_provider',
        'is_client',
        'contact_telephone',
        'contact_name',
        'contact_email',
        'ubigeo',
        'birthdate',
        'names',
        'father_lastname',
        'mother_lastname'
    ];
    // se esta guardando la ruta completa por eso se comento
    // public function getImageAttribute($value)
    // {
    //     return $value ? asset('storage/' . $value) : null;
    // }

    public function district(): HasOne
    {
        return $this->hasOne(District::class, 'id', 'ubigeo');
    }
    public function teacher(): HasOne
    {
        return $this->hasOne(AcaTeacher::class, 'id', 'person_id');
    }
    public function resumes(): HasMany
    {
        return $this->hasMany(AcaTeachingResume::class, 'person_id');
    }
}
