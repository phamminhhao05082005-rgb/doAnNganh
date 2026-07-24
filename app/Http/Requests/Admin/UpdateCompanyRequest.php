<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $company = $this->route('company');

        return [

            'full_name' => 'required|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')
                    ->ignore($company->owner_id)
            ],

            'phone' => 'nullable|max:20',
            'name' => 'required|max:200',
            'website' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable',
            'logo' => 'nullable|max:255'

        ];
    }
}