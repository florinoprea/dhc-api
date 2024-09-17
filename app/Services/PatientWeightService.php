<?php

namespace App\Services;

use App\Repositories\PatientWeightRepository;
use App\Services\Patient\PDF\PatientHistoryWeightPDFService;
use DB;

class PatientWeightService
{
    protected $repository;
    protected $service;

    public function __construct(
        PatientWeightRepository $patientWeightRepository,
        PatientsService $patientService
    )
    {
        $this->repository = $patientWeightRepository;
        $this->service = $patientService;
    }

    public function paginatedSearch(array $filters = [], array $options = [] ){
        return $this->repository->search($filters, $options)->paginate($options['per_page'] ?? 20);
    }
    public function paginatedFrontSearch($patientId, array $filters = [], array $options = [], ){
        return $this->repository->forPatient($patientId)->search($filters, $options)->orderedDescending()->paginate($options['per_page'] ?? 20);
    }

    public function searchForPatient($patientId, array $filters = [], array $options = [],){
        return $this->repository->forPatient($patientId)->search($filters, $options)->fetch();
    }

    public function fetch($rows = null){
        return $this->repository->fetch($rows);
    }


    public function fetchForApp($patientId, $rows = null){
        return $this->repository->forPatient($patientId)->orderedDescending()->fetch($rows);
    }

    public function add($patientId, $attributes){

        return $this->repository->add($patientId, $attributes);
    }





}
?>
