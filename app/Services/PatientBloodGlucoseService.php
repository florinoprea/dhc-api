<?php

namespace App\Services;

use App\Repositories\PatientBloodGlucoseRepository;
use DB;

class PatientBloodGlucoseService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new PatientBloodGlucoseRepository();
    }

    public function paginatedSearch(array $filters = [], array $options = [], ){
        return $this->repository->search($filters, $options)->paginate($options['per_page'] ?? 20);
    }
    public function paginatedFrontSearch($patientId, array $filters = [], array $options = [], ){
        return $this->repository->forPatient($patientId)->search($filters, $options)->orderedDescending()->paginate($options['per_page'] ?? 20);
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
