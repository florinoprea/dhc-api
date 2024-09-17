<?php

namespace App\Repositories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DB;

class PatientsRepository extends AppRepository implements PatientsRepositoryInterface
{
    protected $modelName = User::class;
    protected $allData = [ 'monitoring'];
    protected $imageUploadPath = 'upload/patients/';

    public function __construct()
    {
        self::reset();
    }

    public function search($filters = [], array $options = []): PatientsRepositoryInterface
    {
        if (isset($filters['search']) && trim($filters['search']) != '') {

            $this->model = $this->model->where(function ($query) use ($filters) {
                $query->orWhere(DB::raw('LOWER(`first_name`)'), 'like', '%' . strtolower(trim($filters['search'])) . '%');
                $query->orWhere(DB::raw('LOWER(`last_name`)'), 'like', '%' . strtolower(trim($filters['search'])) . '%');

                $query->orWhere('id', '=', strtolower(trim($filters['search'])));
            });

        }


        if (isset($filters['withoutIds']) && !is_null($filters['withoutIds'])) {
            $this->model = $this->model->whereNotIn('id', $filters['withoutIds']);
        }

        if (isset($filters['status']) && !is_null($filters['status'])) {
            $this->model = $this->model->where('active', '=', $filters['status']);
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
    public function add($attributes)
    {

        try {
            DB::beginTransaction();

            $modelData = $this->model->create([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'email' => $attributes['email'],
                'dob' => $attributes['dob'],
                'password' => Hash::make($attributes['password']),

            ]);
            $modelData->monitoring()->sync($attributes['monitoring']);

            DB::commit();
            return $modelData->load($this->allData);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($attributes)
    {
        try {
            DB::beginTransaction();

            $modelData = $this->getByIdOrFail($attributes['id']);

            $fields = [
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'email' => $attributes['email'],
                'dob' => $attributes['dob'],
            ];

            $modelData->fill($fields)->save();
            $modelData->monitoring()->sync($attributes['monitoring']);

            DB::commit();
            return $modelData->load($this->allData);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updatePin($attributes)
    {
        try {
            DB::beginTransaction();

            $modelData = $this->getByIdOrFail($attributes['id']);

            $fields = [
                'password' => Hash::make($attributes['password']),
            ];

            $modelData->fill($fields)->save();

            DB::commit();
            return $modelData->load($this->allData);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function setStatus($id, $status)
    {
        try {
            DB::beginTransaction();

            $element = $this->getById($id);
            $element->active = $status;
            $element->save();

            DB::commit();
            return $element;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function reset()
    {
        if ($this->modelName) {
            $this->model = $this->modelName::make();
            $this->model = $this->model->patient();
        }
        return $this;
    }
}
