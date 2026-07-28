<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => [
                'required',
                'string',
                'max:255'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],


            'title' => [
                'nullable',
                'string',
                'max:255'
            ],

            'summary' => [
                'nullable',
                'string'
            ],

            'experience_year' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'expected_salary' => [
                'nullable',
                'numeric',
                'min:0'
            ],
        ];
    }
}
