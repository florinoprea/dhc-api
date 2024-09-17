<?php

namespace App\Http\Controllers\API\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequestAPI;
use App\Services\Auth\LoginService;
use Exception;
use App\Http\Responses\ApiResponse;

class LoginController extends Controller
{
    protected $service;
    public function __construct(LoginService $loginService)
    {
        $this->service = $loginService;
    }

    public function login(LoginRequestAPI $request)
    {
        try {
            return $this->service->authenticateFront($request);
        } catch (Exception $e) {
            // Something went wrong with JWT Auth.
            return new ApiResponse($request,[
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
