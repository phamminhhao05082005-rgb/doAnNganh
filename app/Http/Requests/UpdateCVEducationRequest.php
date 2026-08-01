<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCVEducationRequest
extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'school_name' => 'required|max:255',

            'major' => 'required|max:255',

            'degree' => 'nullable|max:255',

            'gpa' => 'nullable|numeric|min:0|max:4',

            'start_date' => 'required|date',

            'end_date' => 'nullable|date|after_or_equal:start_date',

        ];
    }
}