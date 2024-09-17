<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\DefaultFormRequest;

class LoginRequestAPI extends DefaultFormRequest
{

    public function __construct()
    {
        $this->message = 'Login failed. Please review your input.';
        parent::__construct();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
