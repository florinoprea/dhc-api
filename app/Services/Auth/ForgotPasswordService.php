<?php

namespace App\Services\Auth;

use App\Http\Resources\Admin\Users\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class ForgotPasswordService{

    protected $request;
    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return ApiResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetLink($request)
    {
        $this->request = $request;

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Please try again',
                'errors' => [
                    'email' => [__($status)]
                ]
            ]);
        }
        return new ApiResponse($request,[
            'success' => true,
            'message' => __($status)
        ]);
    }
}
