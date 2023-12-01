<?php

namespace Modules\Health\Entities;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HealPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id', 'user_id', 'patient_code'
    ];


    protected static function newFactory()
    {
        return \Modules\Health\Database\factories\HealPatientFactory::new();
    }

    public function person(): HasOne
    {
        return $this->hasOne(Person::class, 'person_id', 'id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
