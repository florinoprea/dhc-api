<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ForgotPasswordRequestAPI;
use App\Services\Auth\ForgotPasswordService;
use Exception;
use App\Http\Responses\ApiResponse;

class ForgotPasswordController extends Controller
{
    protected $service;
    public function __construct(ForgotPasswordService $service)
    {
        $this->service = $service;
    }

    public function sendResetLinkEmail(ForgotPasswordRequestAPI $request)
    {
        try {
            return $this->service->sendResetLink($request);
        } catch (Exception $e) {
            // Something went wrong with JWT Auth.
            return new ApiResponse($request,[
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
