<?php

namespace App\Http\Controllers\API\Front;

use App\Http\Resources\Patients\PatientBloodOxygenCollection;
use App\Http\Resources\Patients\PatientBloodOxygenResource;
use App\Services\PatientBloodOxygenService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class PatientBloodOxygenController extends FrontController
{

    protected $service;

    public function __construct(
        PatientBloodOxygenService $patientBloodOxygenService
    )
    {
        parent::__construct();
        $this->service = $patientBloodOxygenService;
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
            'data' => PatientBloodOxygenResource::collection($this->service->fetchForApp($patientId ,20))
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
            'data' => new PatientBloodOxygenCollection($this->service->paginatedFrontSearch($patientId))
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
            'message' => 'Patient blood oxygen saved.',
            'data' => new PatientBloodOxygenResource($patientData)
        ]);

    }
}
