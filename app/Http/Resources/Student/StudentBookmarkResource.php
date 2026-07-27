<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentBookmarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'description' => $this->description,

            'requirement' => $this->requirement,

            'salary_min' => $this->salary_min,

            'salary_max' => $this->salary_max,

            'location' => $this->location,

            'experience' => $this->experience,

            'deadline' => $this->deadline,

            'status' => $this->status,

            'company' => [
                'id' => $this->company?->id,
                'name' => $this->company?->name,
                'logo' => $this->company?->logo,
            ],

            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ],

            'skills' => $this->skills->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                ];
            }),

            'bookmarked_at' => optional(
                $this->pivot
            )->created_at,
        ];
    }
}