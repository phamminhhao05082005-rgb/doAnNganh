<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirement' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'location' => 'required|string|max:255',
            'experience' => 'nullable|string|max:255',
            'deadline' => 'required|date|after:today',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',

        ];
    }
}