<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'status' => $this->status,

            'applied_at' => $this->applied_at,

            'job' => [

                'id' => $this->job?->id,

                'title' => $this->job?->title,

                'location' => $this->job?->location,

                'salary_min' => $this->job?->salary_min,

                'salary_max' => $this->job?->salary_max,

                'company' => [

                    'id' => $this->job?->company?->id,

                    'name' => $this->job?->company?->name,

                    'logo' => $this->job?->company?->logo

                ]

            ],

            'cv' => [

                'id' => $this->cv?->id,

                'title' => $this->cv?->title,

                'full_name' => $this->cv?->full_name,

                'email' => $this->cv?->email,

                'phone' => $this->cv?->phone,

                'avatar' => $this->cv?->avatar,

                'job_title' => $this->cv?->job_title,

                'experience_year' => $this->cv?->experience_year,

                'expected_salary' => $this->cv?->expected_salary

            ]

        ];
    }
}