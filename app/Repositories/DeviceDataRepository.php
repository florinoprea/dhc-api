<?php

namespace App\Repositories;

use App\Models\Categories;
use App\Models\DeviceData;
use App\Models\PatientWeight;
use App\Models\User;
use App\Traits\TimezoneAwareTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DB;

class DeviceDataRepository extends AppRepository implements DeviceDataRepositoryInterface
{
    use TimezoneAwareTrait;

    protected $modelName = DeviceData::class;
    protected $allData = [];
    protected $imageUploadPath = 'upload/device/';



    /**
     * @param $attributes
     * @throws \Exception
     */
    public function add($attributes)
    {

        try {
            DB::beginTransaction();

            $modelData = $this->model->create([
                'device' => isset($attributes['device']) ? $attributes['device'] : null,
                'data' => isset($attributes['data']) ? $attributes['data'] : null
            ]);

            DB::commit();
            return $modelData->load($this->allData);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
