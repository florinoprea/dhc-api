<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class DefaultFormRequest extends FormRequest
{

    protected $message = '';

    public function __construct()
    {

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

    protected function failedValidation(Validator $validator)
    {
        $err = new RequestValidationException($validator);
        throw ($err->setMessage($this->message))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }
}
