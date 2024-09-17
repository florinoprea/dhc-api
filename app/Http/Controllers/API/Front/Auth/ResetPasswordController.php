<?php


namespace App\Http\Controllers\API\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ResetPasswordRequestAPI;
use App\Services\Auth\ResetPasswordService;
use Exception;
use App\Http\Responses\ApiResponse;

class ResetPasswordController extends Controller
{
    protected $service;

    public function __construct(ResetPasswordService $service)
    {
        $this->service = $service;
    }

    public function reset(ResetPasswordRequestAPI $request)
    {
        try {
            return $this->service->resetPassword($request);
        } catch (Exception $e) {
            // Something went wrong with JWT Auth.
            return new ApiResponse($request, [
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
