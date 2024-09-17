<?php

namespace App\Services;

use App\Repositories\PatientBloodGlucoseRepository;
use App\Repositories\PatientBloodOxygenRepository;
use App\Repositories\PatientBloodPressureRepository;use App\Repositories\PatientsRepository;
use App\Repositories\PatientsRepositoryInterface;
use App\Repositories\PatientWeightRepository;
use App\Services\Patient\PDF\PatientHistoryBloodGlucosePDFService;
use App\Services\Patient\PDF\PatientHistoryBloodOxygenPDFService;
use App\Services\Patient\PDF\PatientHistoryBpPDFService;
use App\Services\Patient\PDF\PatientHistoryWeightPDFService;
use DB;

class PatientsService
{
    protected $repository;
    protected $patientWeightRepository;
    protected $patientBpRepository;
    protected $patientOxygenRepository;
    protected $patientGlucoseRepository;

    public function __construct(
        PatientsRepository $patientsRepository,
        PatientWeightRepository $patientWeightRepository,
        PatientBloodPressureRepository $patientBpRepository,
        PatientBloodOxygenRepository $patientOxygenRepository,
        PatientBloodGlucoseRepository $patientGlucoseRepository
    )
    {
        $this->repository = $patientsRepository;
        $this->patientWeightRepository = $patientWeightRepository;
        $this->patientBpRepository = $patientBpRepository;
        $this->patientOxygenRepository = $patientOxygenRepository;
        $this->patientGlucoseRepository = $patientGlucoseRepository;
    }
    public function paginatedSearch(array $filters = [], array $options = [], ){
        return $this->repository->withAll()->search($filters, $options)->paginate($options['per_page'] ?? 10);
    }

    public function getForFrontend(){

        return $this->repository->active()->ordered()->withAll()->fetch();
    }

    public function getById($id){
        return $this->repository->withAll()->getById($id);
    }

    public function getByIdOrFail($id){
        return $this->repository->withAll()->getByIdOrFail($id);
    }

    public function add($attributes){
        return $this->repository->add($attributes);
    }

    public function update($attributes){
        return $this->repository->update($attributes);
    }

    public function updatePin($attributes){
        return $this->repository->updatePin($attributes);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function setStatus($id, $status)
    {
        return $this->repository->setStatus( $id, $status);
    }

    public function reset()
    {
        $this->repository->reset();
        return $this;
    }

    public function getPatientWeightHistory($patientId, $filters = null, $options = null)
    {
        return $this->patientWeightRepository->forPatient($patientId)->orderedDescending()->search( $filters??[], $options??[])->fetch();
    }

    public function getPatientWeightChart($patientId, $filters = null, $options = null)
    {
        return $this->patientWeightRepository->forPatient($patientId)->orderedAscending()->chart()->search( $filters??[], $options??[])->fetch();
    }

    public function deletePatientWeight($patientWeightId)
    {
        return $this->patientWeightRepository->delete($patientWeightId);
    }

    public function getPatientBpHistory($patientId, $filters = null, $options = null)
    {
        return $this->patientBpRepository->forPatient($patientId)->orderedDescending()->search( $filters??[], $options??[])->fetch();
    }

    public function getPatientBpChart($patientId, $filters = null, $options = null)
    {
        return $this->patientBpRepository->forPatient($patientId)->orderedAscending()->chart()->search( $filters??[], $options??[])->fetch();
    }

    public function deletePatientBp($patientBpId)
    {
        return $this->patientBpRepository->delete($patientBpId);
    }

    //Oxygen
    public function getPatientOxygenHistory($patientId, $filters = null, $options = null)
    {
        return $this->patientOxygenRepository->forPatient($patientId)->orderedDescending()->search( $filters??[], $options??[])->fetch();
    }

    public function getPatientOxygenChart($patientId, $filters = null, $options = null)
    {
        return $this->patientOxygenRepository->forPatient($patientId)->orderedAscending()->chart()->search( $filters??[], $options??[])->fetch();
    }

    public function deletePatientOxygen($patientOxygenId)
    {
        return $this->patientOxygenRepository->delete($patientOxygenId);
    }


    //Glucose
    public function getPatientGlucoseHistory($patientId, $filters = null, $options = null)
    {
        return $this->patientGlucoseRepository->forPatient($patientId)->orderedDescending()->search( $filters??[], $options??[])->fetch();
    }

    public function getPatientGlucoseChart($patientId, $filters = null, $options = null)
    {
        return $this->patientGlucoseRepository->forPatient($patientId)->orderedAscending()->chart()->search( $filters??[], $options??[])->fetch();
    }

    public function deletePatientGlucose($patientGlucoseId)
    {
        return $this->patientGlucoseRepository->delete($patientGlucoseId);
    }
    // --

    public function getPatientHistoryPdf($patientId, $type = 'weight' , $filters = null)
    {
        $patient = $this->getByIdOrFail($patientId);

        switch ($type) {
            case 'weight':
                return (new PatientHistoryWeightPDFService($patient, $filters))->download();
                break;
            case 'blood_pressure':
                return (new PatientHistoryBpPDFService($patient, $filters))->download();
                break;
            case 'blood_glucose':
                return (new PatientHistoryBloodGlucosePDFService($patient, $filters))->download();
                break;
            case 'blood_oxygen':
                return (new PatientHistoryBloodOxygenPDFService($patient, $filters))->download();
                break;
        }

        return null;
    }


}
