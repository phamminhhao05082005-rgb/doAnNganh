<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentExperienceResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'company_name' => $this->company_name,

            'position' => $this->position,

            'start_date' => optional($this->start_date)->format('Y-m-d'),

            'end_date' => optional($this->end_date)->format('Y-m-d'),

            'description' => $this->description,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}