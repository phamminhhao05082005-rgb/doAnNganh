<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CVRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'template_id' => 'required|exists:cv_templates,id',

            'title' => 'required|max:255',

            'full_name' => 'required|max:255',

            'email' => 'required|email',

            'phone' => 'nullable|max:20',

            'avatar' => 'nullable',

            'job_title' => 'nullable|max:255',

            'summary' => 'nullable',

            'experience_year' => 'nullable|integer|min:0',

            'expected_salary' => 'nullable|numeric|min:0',

            'status' => 'boolean'

        ];
    }
}