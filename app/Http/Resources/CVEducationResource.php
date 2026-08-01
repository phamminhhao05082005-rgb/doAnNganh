<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CVEducationResource extends JsonResource
{
    public function toArray(
        Request $request
    ): array
    {
        return [

            'id' => $this->id,

            'school_name' => $this->school_name,

            'major' => $this->major,

            'degree' => $this->degree,

            'gpa' => $this->gpa,

            'start_date' => $this->start_date,

            'end_date' => $this->end_date,

        ];
    }
}