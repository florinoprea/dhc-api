<?php

namespace App\Http\Resources\Patients;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientBloodPressureCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'blood_pressure' => PatientBloodPressureResource::collection($this->collection),
            'meta' => [
                "total"         => $this->total(),
                "per_page"      => $this->perPage(),
                "current_page"  => $this->currentPage(),
                "last_page"     => $this->lastPage(),
                "from"          => $this->firstItem(),
                "to"            => $this->lastItem(),
            ]
        ];
    }
}
