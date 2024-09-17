<?php

namespace App\Http\Controllers\API\Front;

use App\Http\Resources\Patients\PatientBloodGlucoseCollection;
use App\Http\Resources\Patients\PatientBloodGlucoseResource;
use App\Services\PatientBloodGlucoseService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class PatientBloodGlucoseController extends FrontController
{

    protected $service;

    public function __construct(
        PatientBloodGlucoseService $patientBloodGlucoseService
    )
    {
        parent::__construct();
        $this->service = $patientBloodGlucoseService;
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
            'data' => PatientBloodGlucoseResource::collection($this->service->fetchForApp($patientId ,20))
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
            'data' => new PatientBloodGlucoseCollection($this->service->paginatedFrontSearch($patientId))
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
        $patientData = $this->service->add($patientId, $request->all());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient blood glucose saved.',
            'data' => new PatientBloodGlucoseResource($patientData)
        ]);

    }
}
