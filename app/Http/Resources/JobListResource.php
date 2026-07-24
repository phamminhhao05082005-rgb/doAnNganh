<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,

            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'logo' => $this->company->logo,
            ],

            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],

            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'location' => $this->location,
            'experience' => $this->experience,
            'deadline' => $this->deadline,
            'status' => $this->status,
        ];
    }
}