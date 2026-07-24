<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'email'=>[
                'required',
                'email'
            ],

            'password'=>[
                'required',
                'string',
                'min:6'
            ]

        ];
    }

    public function messages(): array
    {
        return [

            'email.required'=>'Email không được để trống',
            'email.email'=>'Email không hợp lệ',
            'password.required'=>'Mật khẩu không được để trống',
            'password.min'=>'Mật khẩu tối thiểu 6 ký tự'

        ];
    }
}