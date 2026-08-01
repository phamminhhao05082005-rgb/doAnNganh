<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CVResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'template_id' => $this->template_id,

            'title' => $this->title,

            'full_name' => $this->full_name,

            'email' => $this->email,

            'phone' => $this->phone,

            'avatar' => $this->avatar,

            'job_title' => $this->job_title,

            'summary' => $this->summary,

            'experience_year' => $this->experience_year,

            'expected_salary' => $this->expected_salary,

            'status' => $this->status,

            'template' => [

                'id' => $this->template->id,

                'name' => $this->template->name,

                'thumbnail' => $this->template->thumbnail,

            ],

            'educations' => $this->educations,

            'experiences' => $this->experiences,

        ];
    }
}