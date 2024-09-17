<?php

namespace App\Http\Controllers\API\Front;

use App\Http\Requests\API\Admin\Patients\Add as PatientAdd;
use App\Http\Resources\DeviceDataResourse;
use App\Http\Resources\Patients\PatientResource;
use App\Http\Resources\Users\UserResource;
use App\Services\DeviceDataService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;

class DeviceDataController extends Controller
{
    protected $service;

    public function __construct(
        DeviceDataService $deviceDataService
    )
    {
        $this->service = $deviceDataService;
    }
    /**
     * Add new record
     *
     * @param Request $request
     * @return ApiResponse
     * @throws \Exception
     */
    public function add(Request $request)
    {

        $deviceData = $this->service->add($request->all());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Device data saved.',
            'data' => new DeviceDataResourse($deviceData)
        ]);
    }
}
