<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CVTemplateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'=>$this->id,

            'name'=>$this->name,

            'description'=>$this->description,

            'thumbnail'=>$this->thumbnail,

            'template_path'=>$this->template_path,

            'is_active'=>$this->is_active

        ];
    }
}