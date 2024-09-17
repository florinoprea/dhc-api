<?php

namespace App\Services;

use App\Repositories\MonitoringCategoriesRepository;
use DB;

class MonitoringCategoriesService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new MonitoringCategoriesRepository();
    }

    public function getForFrontend(){

        return $this->repository->active()->withAll()->fetch();
    }

}
?>
