<?php

namespace App\Repositories;

interface AppRepositoryInterface
{

    public function reset();

    public function withAll(): AppRepositoryInterface;

    public function active(): AppRepositoryInterface;

    public function load($data): AppRepositoryInterface;

    public function with($data): AppRepositoryInterface;

    public function createdAfter($date): AppRepositoryInterface;

    public function createdBefore($date): AppRepositoryInterface;

    public function ordered(): AppRepositoryInterface;

    public function paginate($perPage);

    public function fetch($fetchedRows);

    public function count();

    public function getByIdOrFail($id);

    public function getById($id);

    public function getFrontendById($id);

    public function first();

    public function getFrontendBySlug($slug);

    public function delete($id);

}
