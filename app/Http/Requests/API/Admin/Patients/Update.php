<?php

namespace App\Http\Requests\API\Admin\Patients;

use App\Http\Requests\DefaultFormRequest;
use App\Rules\Patients\PatientExists;
use Illuminate\Validation\Rule;

class Update extends DefaultFormRequest
{
    public function __construct()
    {
        $this->message = 'Patient could not be saved. Please review your input.';
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
            'id' => [
                'bail',
                'required',
                $patientExists
            ],
            'first_name' => [
                'required',
                'max:191'
            ],
            'last_name' => [
                'required',
                'max:191'
            ],
            'dob' => [
                'required',
                'date_format:m/d/Y',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'monitoring' => [
                'required'
            ],
        ];
    }
}
