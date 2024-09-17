<?php

namespace App\Repositories;

use App\Models\MonitoringCategory;
use DB;

class MonitoringCategoriesRepository extends AppRepository implements MonitoringCategoriesRepositoryInterface
{
    protected $modelName = MonitoringCategory::class;
    protected $allData = [];
    protected $imageUploadPath = 'upload/patients/';



}
