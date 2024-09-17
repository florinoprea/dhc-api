<?php
namespace App\Http\Requests\API\Auth;

use App\Http\Requests\DefaultFormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class ResetPasswordRequestAPI extends DefaultFormRequest
{

    public function __construct()
    {
        $this->message = 'Password reset failed. Please review your input.';
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
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
