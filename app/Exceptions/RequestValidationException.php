<?php
/**
 * Created by PhpStorm.
 * User: adi
 * Date: 7/26/19
 * Time: 10:47 AM
 */

namespace App\Exceptions;
use Illuminate\Validation\ValidationException;


class RequestValidationException extends ValidationException
{
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

}
