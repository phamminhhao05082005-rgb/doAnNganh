<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'=>$this->id,
            'company_name'=>$this->name,
            'website'=>$this->website,
            'owner'=>$this->owner->full_name,
            'email'=>$this->owner->email,
            'phone'=>$this->owner->phone

        ];
    }
}