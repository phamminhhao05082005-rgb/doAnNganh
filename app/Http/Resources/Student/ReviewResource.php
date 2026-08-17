<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'company_id' => $this->company_id,
            'rating'     => $this->rating,
            'comment'    => $this->comment,
            'user'       => [
                'id'        => $this->user->id ?? null,
                'full_name' => $this->user->full_name ?? null,
                'avatar'    => $this->user->avatar ?? null,
            ],
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}