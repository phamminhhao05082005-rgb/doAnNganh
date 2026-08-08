<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'status' => [

                'required',

                Rule::in([
                    'PENDING',
                    'REVIEWING',
                    'INTERVIEW',
                    'ACCEPTED',
                    'REJECTED'
                ])

            ]

        ];
    }

    public function messages(): array
    {
        return [

            'status.required' => 'Vui lòng chọn trạng thái.',

            'status.in' => 'Trạng thái không hợp lệ.'

        ];
    }
}