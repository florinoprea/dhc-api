<?php

namespace App\Http\Resources\Patients;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientsCollection extends ResourceCollection
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
            'patients' => PatientResource::collection($this->collection),
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
