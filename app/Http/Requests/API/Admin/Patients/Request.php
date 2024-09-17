<?php

namespace App\Http\Requests\API\Admin\Patients;

use App\Http\Requests\DefaultFormRequest;
use App\Rules\Patients\PatientExists;


class Request extends DefaultFormRequest
{
    public function __construct()
    {
        $this->message = 'Patient not found. Please review your input.';
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
    public function rules( PatientExists $patientExists)
    {

        return [
            'id' =>[
                'required',
                $patientExists
            ]
        ];
    }
}