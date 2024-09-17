<?php

namespace App\Http\Controllers\API\Front;

use App\Http\Resources\Patients\PatientResource;
use App\Http\Resources\Users\UserResource;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;

class FrontController extends Controller
{

    protected $patient;


    public function __construct()
    {
        $this->patient = Auth::user();
    }

    public function account(Request $request){
        $user = Auth::guard('api')->user();
        $user = $user->load(['monitoring', 'last_weight', 'last_blood_pressure']);
        return new ApiResponse($request, [
            'data' => [
                'user' => PatientResource::make($user),
            ]
        ]);
    }

    public function getPatient(){
        return $this->patient;
    }

    public function getPatientId(){
        return $this->patient->id;
    }
}
