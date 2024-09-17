<?php

namespace App\Repositories;

use App\Models\Categories;
use App\Models\PatientBloodGlucose;
use App\Models\PatientBloodOxygen;
use App\Models\PatientBloodPreasure;
use App\Models\PatientBloodPressure;
use App\Models\PatientWeight;
use App\Models\User;
use App\Traits\TimezoneAwareTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DB;

class PatientBloodGlucoseRepository extends AppRepository implements PatientBloodGlucoseRepositoryInterface
{
    use TimezoneAwareTrait;

    protected $modelName = PatientBloodGlucose::class;
    protected $allData = [ 'patient'];
    protected $imageUploadPath = 'upload/patients/';


    public function setPeriod( $from = null, $to = null){

        if (!is_null($from)) {
            $this->model = $this->model->where('created_at', '>=' , Carbon::createFromFormat('m/d/Y', $from, $this->timezone_user())->startOfDay()->timezone($this->timezone_db())->toDateTimeString());
        }
        if (!is_null($to)) {
            $this->model = $this->model->where('created_at', '<=' , Carbon::createFromFormat('m/d/Y', $to, $this->timezone_user())->endOfDay()->timezone($this->timezone_db())->toDateTimeString());
        }
        return $this;
    }

    public function search($filters = [], array $options = [])
    {
        if (isset($filters['search']) && trim($filters['search']) != '') {

            $this->model = $this->model->where(function ($query) use ($filters) {
                $query->orWhere(DB::raw('LOWER(`first_name`)'), 'like', '%' . strtolower(trim($filters['search'])) . '%');
                $query->orWhere(DB::raw('LOWER(`last_name`)'), 'like', '%' . strtolower(trim($filters['search'])) . '%');

                $query->orWhere('id', '=', strtolower(trim($filters['search'])));
            });

        }


        if (isset($filters['period']) && !is_null($filters['period'])) {
            $this->setPeriod($filters['period']['from'], $filters['period']['to']);
        }

        if (isset($options['order_by'])) {
            $this->model = $this->model->orderBy($options['order_by'], isset($options['order_type']) ? $options['order_type'] : 'asc');
        }

        return $this;
    }

    /**
     * @param $attributes
     * @throws \Exception
     */
    public function add($patientId, $attributes)
    {

        try {
            DB::beginTransaction();

            $modelData = $this->model->create([
                'patient_id' => $patientId,
                'glucose' => $attributes['glucose']
            ]);

            DB::commit();
            return $modelData->load($this->allData);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function forPatient($patientId)
    {
        $this->model = $this->model->where('patient_id' , $patientId );
        return $this;
    }

    public function orderedDescending()
    {
        $this->model = $this->model->orderBy('created_at' , 'DESC' );
        return $this;
    }

    public function orderedAscending()
    {
        $this->model = $this->model->orderBy('created_at' , 'ASC' );
        return $this;
    }

    public function chart()
    {
        return $this;
    }
}
