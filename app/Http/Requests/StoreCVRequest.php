<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCVRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'template_id' => 'required|exists:cv_templates,id',

        ];
    }

    public function messages(): array
    {
        return [

            'template_id.required' => 'Vui lòng chọn mẫu CV.',

            'template_id.exists' => 'Mẫu CV không tồn tại.',

        ];
    }
}