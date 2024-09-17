<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Resources\Users\UserResource;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;

class AdminController extends Controller
{

    public function account(Request $request){
        return new ApiResponse($request, [
            'data' => [
                'user' => UserResource::make(Auth::guard('api')->user()),
            ]
        ]);
    }
}
