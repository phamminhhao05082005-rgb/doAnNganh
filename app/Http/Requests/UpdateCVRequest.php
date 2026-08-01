<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCVRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'title' => 'required|max:255',

            'full_name' => 'required|max:255',

            'email' => 'required|email',

            'phone' => 'nullable|max:20',

            'avatar' => 'nullable',

            'job_title' => 'nullable|max:255',

            'summary' => 'nullable',

            'experience_year' => 'nullable|integer|min:0',

            'expected_salary' => 'nullable|numeric|min:0',

            'status' => 'required|boolean',

        ];
    }

    public function messages(): array
    {
        return [

            'title.required' => 'Vui lòng nhập tên CV.',

            'full_name.required' => 'Vui lòng nhập họ tên.',

            'email.required' => 'Vui lòng nhập email.',

            'email.email' => 'Email không hợp lệ.',

            'experience_year.integer' => 'Số năm kinh nghiệm không hợp lệ.',

            'expected_salary.numeric' => 'Mức lương mong muốn không hợp lệ.',

        ];
    }
}