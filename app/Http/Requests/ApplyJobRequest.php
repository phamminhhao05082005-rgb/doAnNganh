<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_id' => 'required|exists:jobs,id',
            'cv_id' => 'required|exists:cvs,id'
        ];
    }

    public function messages(): array
    {
        return [
            'cv_id.required' => 'Vui lòng chọn CV.',
            'cv_id.exists' => 'CV không tồn tại.'
        ];
    }
}