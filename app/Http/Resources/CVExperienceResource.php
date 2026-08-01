<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CVExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'company_name' => $this->company_name,

            'position' => $this->position,

            'start_date' => $this->start_date,

            'end_date' => $this->end_date,

            'description' => $this->description,

        ];
    }
}