<?php

namespace App\Providers;

use App\Models\PatientWeight;
use App\Repositories\MonitoringCategoriesRepository;
use App\Repositories\MonitoringCategoriesRepositoryInterface;
use App\Repositories\PatientBloodGlucoseRepository;
use App\Repositories\PatientBloodGlucoseRepositoryInterface;
use App\Repositories\PatientBloodOxygenRepository;
use App\Repositories\PatientBloodOxygenRepositoryInterface;
use App\Repositories\PatientBloodPressureRepository;
use App\Repositories\PatientBloodPressureRepositoryInterface;
use App\Repositories\PatientsRepository;
use App\Repositories\PatientsRepositoryInterface;
use App\Repositories\PatientWeightRepository;
use App\Repositories\PatientWeightRepositoryInterface;
use App\Services\MonitoringCategoriesService;
use App\Services\PatientBloodGlucoseService;
use App\Services\PatientBloodOxygenService;
use App\Services\PatientBloodPressureService;
use App\Services\PatientsService;
use App\Services\PatientWeightService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * @var string[]
     */
    public $bindings = [

        // Patients
        PatientsService::class => PatientsService::class,
        PatientsRepositoryInterface::class => PatientsRepository::class,

        // Monitoring
        MonitoringCategoriesService::class => MonitoringCategoriesService::class,
        MonitoringCategoriesRepositoryInterface::class => MonitoringCategoriesRepository::class,

        // Weight
        PatientWeightService::class => PatientWeightService::class,
        PatientWeightRepositoryInterface::class => PatientWeightRepository::class,

        // Blood Pressure Monitor
        PatientBloodPressureService::class => PatientBloodPressureService::class,
        PatientBloodPressureRepositoryInterface::class => PatientBloodPressureRepository::class,

        // Blood Oxygen Monitor
        PatientBloodOxygenService::class => PatientBloodOxygenService::class,
        PatientBloodOxygenRepositoryInterface::class => PatientBloodOxygenRepository::class,

        // Blood Glucose Monitor
        PatientBloodGlucoseService::class => PatientBloodGlucoseService::class,
        PatientBloodGlucoseRepositoryInterface::class => PatientBloodGlucoseRepository::class,

    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
