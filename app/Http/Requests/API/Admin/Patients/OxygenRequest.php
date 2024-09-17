<?php

namespace App\Http\Requests\API\Admin\Patients;

use App\Http\Requests\DefaultFormRequest;
use App\Rules\Patients\PatientOxygenExists;


class OxygenRequest extends DefaultFormRequest
{
    public function __construct()
    {
        $this->message = 'Patient blood oxygen record not found. Please review your input.';
        parent::__construct();
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules( PatientOxygenExists $patientOxygenExists)
    {

        return [
            'id' =>[
                'required',
                $patientOxygenExists
            ]
        ];
    }
}
