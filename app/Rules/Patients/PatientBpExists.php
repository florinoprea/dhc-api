<?php

namespace App\Rules\Patients;

use App\Models\PatientBloodPressure;
use Illuminate\Contracts\Validation\Rule;
use Log;

class PatientBpExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return PatientBloodPressure::find($value) !== null ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You are trying to access an inexistent patient blood pressure record.';
    }
}
