<?php

namespace App\Http\Controllers\API\Front;

use App\Http\Resources\Patients\PatientBloodPressureCollection;
use App\Http\Resources\Patients\PatientBloodPressureResource;
use App\Services\PatientBloodPressureService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class PatientBloodPressureController extends FrontController
{

    protected $service;

    public function __construct(
        PatientBloodPressureService $patientBloodPressureService
    )
    {
        parent::__construct();
        $this->service = $patientBloodPressureService;
    }
    /**
     * Fetch records listing
     *
     * @param Request $request
     * @return ApiResponse
     */
    public function index(Request $request)
    {
        $patientId = Auth::id();
        return new ApiResponse($request, [
            'data' => PatientBloodPressureResource::collection($this->service->fetchForApp($patientId ,20))
        ]);
    }

    /**
     * Fetch records listing paginated
     *
     * @param Request $request
     * @return ApiResponse
     */
    public function getPaginated(Request $request)
    {
        $patientId = Auth::id();
        return new ApiResponse($request, [
            'data' => new PatientBloodPressureCollection($this->service->paginatedFrontSearch($patientId))
        ]);
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
        $patientId = Auth::id();
        $patientBP = $this->service->add($patientId, $request->all());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient blood pressure saved.',
            'data' => new PatientBloodPressureResource($patientBP)
        ]);

    }
}
