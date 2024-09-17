<?php

namespace App\Services;

use App\Repositories\DeviceDataRepository;
use App\Repositories\PatientBloodPressureRepository;use App\Repositories\PatientsRepository;
use App\Repositories\PatientsRepositoryInterface;
use App\Repositories\PatientWeightRepository;
use App\Services\Patient\PDF\PatientHistoryBpPDFService;
use App\Services\Patient\PDF\PatientHistoryWeightPDFService;
use DB;

class DeviceDataService
{
    protected $repository;

    public function __construct(
        DeviceDataRepository $deviceDataRepository
    )
    {
        $this->repository = $deviceDataRepository;
    }

    public function add($attributes){
        return $this->repository->add($attributes);
    }

}
?>
