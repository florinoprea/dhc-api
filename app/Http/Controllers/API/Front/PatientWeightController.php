<?php

namespace App\Http\Controllers\API\Front;

use App\Http\Resources\Patients\PatientWeightCollection;
use App\Http\Resources\Patients\PatientWeightResource;
use App\Services\PatientWeightService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class PatientWeightController extends FrontController
{

    protected $service;

    public function __construct(
        PatientWeightService $patientWeightService
    )
    {
        parent::__construct();
        $this->service = $patientWeightService;
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
            'data' => PatientWeightResource::collection($this->service->fetchForApp($patientId, 20))
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
            'data' => new PatientWeightCollection($this->service->paginatedFrontSearch($patientId))
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

        $patientWeight = $this->service->add($patientId, $request->all());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient weight saved.',
            'data' => new PatientWeightResource($patientWeight)
        ]);

    }
}
