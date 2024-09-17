<?php

namespace App\Http\Requests\API\Admin\Patients;

use App\Http\Requests\DefaultFormRequest;

class Add extends DefaultFormRequest
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
    public function rules()
    {
        return [
            'first_name' => [
                'required',
                'max:191'
            ],
            'last_name' => [
                'required',
                'max:191'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'dob' => [
                'required',
                'date_format:m/d/Y',
            ],
            'password' => [
                'required',
                'confirmed'
            ],
            'password_confirmation' => [
                'required'
            ],
            'monitoring' => [
                'required'
            ],
        ];
    }
}
