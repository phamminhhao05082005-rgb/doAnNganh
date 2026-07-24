<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|max:20',

            'name' => 'required|max:200',
            'website' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable',
            'logo' => 'nullable|max:255'
        ];
    }
}