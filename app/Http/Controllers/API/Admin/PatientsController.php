<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\Patients\Get as PatientsGet;
use App\Http\Requests\API\Admin\Patients\Add as PatientAdd;
use App\Http\Requests\API\Admin\Patients\Update as PatientUpdate;
use App\Http\Requests\API\Admin\Patients\UpdatePin as PatientUpdatePin;
use App\Http\Requests\API\Admin\Patients\Status as PatientStatus;
use App\Http\Requests\API\Admin\Patients\Request as PatientRequest;
use App\Http\Requests\API\Admin\Patients\BpRequest as PatientBpRequest;
use App\Http\Requests\API\Admin\Patients\OxygenRequest as PatientOxygenRequest;
use App\Http\Requests\API\Admin\Patients\GlucoseRequest as PatientGlucoseRequest;
use App\Http\Requests\API\Admin\Patients\WeightRequest as PatientWeightRequest;
use App\Http\Resources\MonitoringCategoryResourse;
use App\Http\Resources\Patients\PatientBloodGlucoseResource;
use App\Http\Resources\Patients\PatientBloodOxygenResource;
use App\Http\Resources\Patients\PatientBloodPressureResource;
use App\Http\Resources\Patients\PatientResource;
use App\Http\Resources\Patients\PatientsCollection;
use App\Http\Resources\Patients\PatientWeightResource;
use App\Http\Responses\ApiResponse;
use App\Services\MonitoringCategoriesService;
use App\Services\PatientsService;
use Illuminate\Support\Facades\Request;


class PatientsController extends AdminController
{
    protected $service;
    protected $monitoringService;

    public function __construct(
        PatientsService $patientsService,
        MonitoringCategoriesService $monitoringService
    )
    {
        $this->service = $patientsService;
        $this->monitoringService = $monitoringService;
    }

    /**
     * Get metadata
     *
     * @param Request $request
     * @return ApiResponse
     */
    public function misc(Request $request)
    {
        return new ApiResponse($request, [
            'data' => [
                'monitoring' => MonitoringCategoryResourse::collection($this->monitoringService->getForFrontend())
            ]
        ]);
    }

    /**
     * Fetch records listing
     *
     * @param PatientsGet $request
     * @return ApiResponse
     */
    public function index(PatientsGet $request)
    {
        return new ApiResponse($request, [
            'data' => new PatientsCollection($this->service->paginatedSearch($request->filters, $request->options))
        ]);
    }

    /**
     * Fetch details for one record
     *
     * @param PatientRequest $request
     * @return ApiResponse
     */
    public function get(PatientRequest $request)
    {

        $category = $this->service->getByIdOrFail($request->id);

        return new ApiResponse($request, [
            'data' => new PatientResource($category)
        ]);

    }
    /**
     * Add new record
     *
     * @param PatientAdd $request
     * @return ApiResponse
     * @throws \Exception
     */
    public function add(PatientAdd $request)
    {

        $category = $this->service->add($request->validationData());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient saved.',
            'data' => new PatientResource($category)
        ]);

    }
    /**
     * Update record
     *
     * @param PatientUpdate $request
     * @return ApiResponse
     * @throws \Exception
     */
    public function update(PatientUpdate $request)
    {

        $patient = $this->service->update($request->validationData());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient updated.',
            'data' => new PatientResource($patient)
        ]);

    }
    /**
     * Update record
     *
     * @param PatientUpdatePin $request
     * @return ApiResponse
     * @throws \Exception
     */
    public function updatePin(PatientUpdatePin $request)
    {

        $patient = $this->service->updatePin($request->validationData());

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient PIN Code updated.',
            'data' => new PatientResource($patient)
        ]);

    }

    /**
     * Update record status
     *
     * @param PatientStatus $request
     * @return ApiResponse
     * @throws \Exception
     */
    public function status(PatientStatus $request)
    {

        $category = $this->service->setStatus($request->id, $request->status);

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient status updated.',
            'data' => new PatientResource($category)
        ]);

    }

    /**
     * Delete record
     *
     * @param PatientRequest $request
     * @return ApiResponse
     */
    public function delete(PatientRequest $request)
    {

        $status = $this->service->delete($request->id);

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient deleted.'
        ]);

    }


    /**
     * Get Patient Weight Hystory
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientWeightHistory(PatientRequest $request)
    {

        $weightHistory = $this->service->getPatientWeightHistory($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientWeightResource::collection($weightHistory)
        ]);

    }

    /**
     * Get Patient Weight Chart
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientWeightChart(PatientRequest $request)
    {

        $weightHistory = $this->service->getPatientWeightChart($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientWeightResource::collection($weightHistory)
        ]);

    }

    /**
     * Delete Patient Weight
     *
     * @param  PatientWeightRequest  $request
     * @return ApiResponse
     */
    public function deletePatientWeight(PatientWeightRequest $request)
    {

        $weightHistory = $this->service->deletePatientWeight($request->id);

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient weight record has been deleted',
        ]);

    }

    /**
     * Get Patient Bp Chart
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientBpChart(PatientRequest $request)
    {

        $weightHistory = $this->service->getPatientBpChart($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientBloodPressureResource::collection($weightHistory)
        ]);

    }



    /**
     * Get Patient Bp Hystory
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientBpHistory(PatientRequest $request)
    {

        $bpHistory = $this->service->getPatientBpHistory($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientBloodPressureResource::collection($bpHistory)
        ]);

    }

    /**
     * Delete Patient Weight
     *
     * @param  PatientBpRequest  $request
     * @return ApiResponse
     */
    public function deletePatientBp(PatientBpRequest $request)
    {

        $weightHistory = $this->service->deletePatientBp($request->id);

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient blood pressure record has been deleted',
        ]);

    }


    /**
     * Get Patient Oxygen Chart
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientOxygenChart(PatientRequest $request)
    {

        $weightHistory = $this->service->getPatientOxygenChart($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientBloodOxygenResource::collection($weightHistory)
        ]);

    }



    /**
     * Get Patient Oxygen Hystory
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientOxygenHistory(PatientRequest $request)
    {

        $bpHistory = $this->service->getPatientOxygenHistory($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientBloodOxygenResource::collection($bpHistory)
        ]);

    }

    /**
     * Delete Patient Oxygen
     *
     * @param  PatientOxygenRequest  $request
     * @return ApiResponse
     */
    public function deletePatientOxygen(PatientOxygenRequest $request)
    {

        $weightHistory = $this->service->deletePatientOxygen($request->id);

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient blood oxygen record has been deleted',
        ]);

    }


    /**
     * Get Patient Glucose Chart
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientGlucoseChart(PatientRequest $request)
    {

        $history = $this->service->getPatientGlucoseChart($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientBloodGlucoseResource::collection($history)
        ]);

    }



    /**
     * Get Patient Glucose Hystory
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientGlucoseHistory(PatientRequest $request)
    {

        $history = $this->service->getPatientGlucoseHistory($request->id, $request->filters , $request->options);

        return new ApiResponse($request, [
            'data' => PatientBloodGlucoseResource::collection($history)
        ]);

    }

    /**
     * Delete Patient Glucose
     *
     * @param  PatientGlucoseRequest  $request
     * @return ApiResponse
     */
    public function deletePatientGlucose(PatientGlucoseRequest $request)
    {

        $weightHistory = $this->service->deletePatientGlucose($request->id);

        return new ApiResponse($request, [
            'success' => true,
            'message' => 'Patient blood glucose record has been deleted',
        ]);

    }

    /**
     * Patient PDF
     *
     * @param  PatientRequest  $request
     * @return ApiResponse
     */
    public function getPatientHistory(PatientRequest $request)
    {
        return $this->service->getPatientHistoryPdf($request->id, $request->screen, $request->filters);

    }

}
