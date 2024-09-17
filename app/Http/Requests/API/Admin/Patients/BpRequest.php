<?php

namespace App\Http\Requests\API\Admin\Patients;

use App\Http\Requests\DefaultFormRequest;
use App\Rules\Patients\PatientBpExists;
use App\Rules\Patients\PatientWeightExists;


class BpRequest extends DefaultFormRequest
{
    public function __construct()
    {
        $this->message = 'Patient blood pressure record not found. Please review your input.';
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
    public function rules( PatientBpExists $patientBpExists)
    {

        return [
            'id' =>[
                'required',
                $patientBpExists
            ]
        ];
    }
}
