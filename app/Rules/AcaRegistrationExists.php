<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AcaRegistrationExists implements Rule
{
    protected $parameter;


    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    public function passes($attribute, $value)
    {
        $exists = DB::table('aca_cap_registrations')
            ->where('student_id', $value)
            ->where('course_id', $this->parameter)
            ->exists();

        if ($exists) {
            return true;
        }
    }

    public function message()
    {
        return 'El alumno no tiene una matricula registrada para el curso elejido.';
    }
}
