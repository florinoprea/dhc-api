<?php

namespace App\Repositories;

interface PatientBloodGlucoseRepositoryInterface extends AppRepositoryInterface
{
    public function setPeriod($from, $to);

    public function search($filters = [], array $options = []);

    public function add($patientId, $attributes);

    public function forPatient($patientId);

    public function chart();

    public function orderedDescending();

    public function orderedAscending();
}
