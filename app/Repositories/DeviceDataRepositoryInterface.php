<?php

namespace App\Repositories;

interface DeviceDataRepositoryInterface extends AppRepositoryInterface
{
    public function add($attributes);
}
