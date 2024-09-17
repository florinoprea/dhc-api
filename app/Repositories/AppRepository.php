<?php

namespace App\Repositories;

use App\Traits\DownloadTrait;
use App\Traits\TimezoneAwareTrait;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AppRepository implements AppRepositoryInterface
{
    use DownloadTrait;
    use TimezoneAwareTrait;

    protected $model;
    protected $modelName = null;
    protected $allData = [];

    public function __construct()
    {
        self::reset();
    }

    public function reset()
    {
        if ($this->modelName) $this->model = $this->modelName::make();
        return $this;
    }

    public function withAll(): AppRepositoryInterface
    {
        $this->model = $this->model->with($this->allData);
        return $this;
    }

    public function active(): AppRepositoryInterface
    {
        $this->model = $this->model->active();
        return $this;
    }

    public function load($data): AppRepositoryInterface
    {
        $this->model = $this->model->load($data);
        return $this;
    }

    public function with($data): AppRepositoryInterface
    {
        $this->model = $this->model->with($data);
        return $this;
    }

    public function createdAfter($date): AppRepositoryInterface
    {
        $this->model = $this->model->where(function ($query) use ($date) {
            $query->where('created_at', '>=', $date);
        });
        return $this;
    }

    public function createdBefore($date): AppRepositoryInterface
    {
        $this->model = $this->model->where(function ($query) use ($date) {
            $query->where('created_at', '<=', $date);
        });
        return $this;
    }

    public function ordered():AppRepositoryInterface
    {
        $this->model = $this->model->ordered();
        return $this;
    }

    public function skip($skipNumbers)
    {
        $this->model = $this->model->skip($skipNumbers);
        return $this;
    }

    public function paginate($perPage){
        return $this->model->paginate($perPage);
    }

    public function fetch($fetchedRows = null){
        if ($fetchedRows) $this->model->take($fetchedRows);
        return $this->model->get();
    }



    public function count(){
        return $this->model->count();
    }

    public function getByIdOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getFrontendById($id)
    {
        return $this->model->active()->findOrFail($id);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function delete($id)
    {
        $this->model = $this->getById($id);

        return $this->model->delete();
    }

    public function getFrontendBySlug($slug)
    {
        return $this->model->where('slug', '=', $slug)->first();
    }


}
