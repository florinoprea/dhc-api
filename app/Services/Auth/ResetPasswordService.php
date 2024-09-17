<?php

namespace App\Services\Auth;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class ResetPasswordService{

    protected $request;

    public function resetPassword($request)
    {
        $this->request = $request;
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Please try again.',
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
