<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'name' => 'required|string|max:200',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:255',

        ];
    }
}