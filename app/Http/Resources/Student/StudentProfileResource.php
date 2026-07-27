<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $profile = $this->candidateProfile;

        return [

            'id' => $this->id,

            'full_name' => $this->full_name,

            'email' => $this->email,

            'phone' => $this->phone,

            'avatar' => $this->avatar,

            'title' => optional($profile)->title,

            'summary' => optional($profile)->summary,

            'experience_year' => optional($profile)->experience_year,

            'expected_salary' => optional($profile)->expected_salary,
        ];
    }
}