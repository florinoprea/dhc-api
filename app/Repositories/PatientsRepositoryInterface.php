<?php

namespace App\Repositories;

interface PatientsRepositoryInterface extends AppRepositoryInterface
{
    public function search($filters = [], array $options = []): PatientsRepositoryInterface;

    public function add($attributes);

    public function update($attributes);

    public function updatePin($attributes);

    public function setStatus($model, $status);

    public function reset();
}
