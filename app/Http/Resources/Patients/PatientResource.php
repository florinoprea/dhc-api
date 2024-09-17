<?php

namespace App\Http\Resources\Patients;

use App\Http\Resources\MonitoringCategoryResourse;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'dob' => $this->dob !== null ? $this->dob->format('m/d/Y') : null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'active' => $this->active,

            'monitoring' => MonitoringCategoryResourse::collection($this->whenLoaded('monitoring')),

            $this->mergeWhen($this->whenLoaded('last_weight') || $this->whenLoaded('last_blood_pressure'),
                [
                'readings' => [
                    $this->mergeWhen($this->whenLoaded('last_weight'),
                        [
                            'weight' => new PatientWeightResource($this->whenLoaded('last_weight'))
                        ]
                    ),
                    $this->mergeWhen($this->whenLoaded('last_blood_pressure'),
                        [
                            'blood_pressure' => new PatientBloodPressureResource($this->whenLoaded('last_blood_pressure'))
                        ]
                    )
                ]
                ]
            ),
        ];
    }
}
