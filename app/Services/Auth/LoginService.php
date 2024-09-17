<?php

namespace App\Services\Auth;

use App\Http\Resources\Patients\PatientResource;
use App\Http\Resources\Users\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class LoginService{

    protected $request;
    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return ApiResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate($request)
    {
        $this->request = $request;
        $this->ensureIsNotRateLimited();
        try {
            if (! $token = JWTAuth::attempt($this->credentials($request))) {
                RateLimiter::hit($this->throttleKey());
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                //$this->incrementLoginAttempts($request);
                //return $this->sendFailedLoginResponse($request);
                //return response()->json([
                //    'status' => 'error',
                //    'message' => 'We can`t find an account with this credentials.'
                //], 401);

                return new ApiResponse($request,[
                    'success' => false,
                    'message' => 'We can`t find an account with these credentials.',
                    'errors' => [
                        'email' => ["These credentials do not match our records."]
                    ]
                ], 400);

            }
        } catch (JWTException $e) {
            // Something went wrong with JWT Auth.
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Failed to login, please try again. '
            ], 500);
        }

        RateLimiter::clear($this->throttleKey());

        $user = Auth::user();
        if( ! $user->is_admin){
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Failed to login, please try again. '
            ], 401);
        }

        if( ! $user->active){
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Failed to login, please try again. '
            ], 401);
        }

        return new ApiResponse($request, [
            'success' => true,
            'data'=> [
                'token' => $token,
                'user' => UserResource::make(Auth::user())
                // You can add more details here as per you requirment.
            ]
        ]);

    }

    public function authenticateFront($request)
    {
        $this->request = $request;
        $this->ensureIsNotRateLimited();
        try {
            if (! $token = JWTAuth::attempt($this->credentials($request))) {
                RateLimiter::hit($this->throttleKey());
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                //$this->incrementLoginAttempts($request);
                //return $this->sendFailedLoginResponse($request);
                //return response()->json([
                //    'status' => 'error',
                //    'message' => 'We can`t find an account with this credentials.'
                //], 401);

                return new ApiResponse($request,[
                    'success' => false,
                    'message' => 'We can`t find an account with these credentials.',
                    'errors' => [
                        'email' => ["These credentials do not match our records."]
                    ]
                ], 400);

            }
        } catch (JWTException $e) {
            // Something went wrong with JWT Auth.
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Failed to login, please try again. '
            ], 500);
        }

        RateLimiter::clear($this->throttleKey());

        $user = Auth::user();
        if( $user->is_admin){
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Failed to login, please try again. '
            ], 401);
        }

        if( ! $user->active){
            return new ApiResponse($request,[
                'success' => false,
                'message' => 'Failed to login, please try again. '
            ], 401);
        }

        $user = $user->load('monitoring', 'last_weight', 'last_blood_pressure');
        return new ApiResponse($request, [
            'success' => true,
            'data'=> [
                'token' => $token,
                'user' => PatientResource::make($user)
                // You can add more details here as per you requirment.
            ]
        ]);

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this->request));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->request->input('email')).'|'.$this->request->ip();
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }
}
?>
