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

            'ai_score' => $this->ai_score,

            'ai_evaluation' => $this->ai_evaluation,

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

            'cv' => $this->cv ? new CvResource($this->cv) : null

        ];
    }
}
