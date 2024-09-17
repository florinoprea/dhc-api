<?php

namespace App\Http\Resources\Patients;

use App\Http\Resources\MonitoringCategoryResourse;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientWeightResource extends JsonResource
{
    /**
     * @var array
     */
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'weight' => $this->weight,
            'created_at' => $this->created_at,

            'patient' => new PatientResource($this->whenLoaded('patient'))
        ];
    }
}
