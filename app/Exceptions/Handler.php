<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            return new ApiResponse($request, null, 401, 'Your session expired. Please sign in again.' ) ;
        });

        $this->renderable(function (TokenInvalidException $e, $request) {
            return new ApiResponse($request, null, 401, 'INVALID TOKEN' ) ;
        });

        $this->renderable(function (TokenBlacklistedException $e, $request) {
            return new ApiResponse($request, null, 401, 'TOKEN BLACKLISTED' ) ;
        });

        $this->renderable(function (ValidationException $e, $request) {
            return new ApiResponse($request, $this->validationException($e), 422 ) ;
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return new ApiResponse($request, null, 422 , 'Route not found' ) ;
        });

        $this->renderable(function (Exception $e, $request) {
            return new ApiResponse($request, null, 500, $e->getMessage() ) ;
        });

        $this->reportable(function (Throwable $e) {
            //
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function validationException($e, $message='Validation exception')
    {
        return [
            'message' => $e->getMessage(),
            'errors' => $e->errors()
        ];
    }
}
