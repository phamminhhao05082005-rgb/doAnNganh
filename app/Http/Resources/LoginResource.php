<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'message'=>'Đăng nhập thành công',
            'token'=>$this['token'],
            'user'=>new UserResource($this['user'])

        ];
    }
}