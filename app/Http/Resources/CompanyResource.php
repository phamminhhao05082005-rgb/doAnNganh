<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'=>$this->id,
            'name'=>$this->name,
            'website'=>$this->website,
            'address'=>$this->address,
            'description'=>$this->description,
            'logo'=>$this->logo,

            'owner'=>[
                'id'=>$this->owner->id,
                'full_name'=>$this->owner->full_name,
                'email'=>$this->owner->email,
                'phone'=>$this->owner->phone,
                'status'=>$this->owner->status
            ]

        ];
    }
}