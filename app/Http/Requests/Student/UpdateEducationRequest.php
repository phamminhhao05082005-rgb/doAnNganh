<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEducationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
           'school_name' => 'required|max:255',

            'major' => 'required|max:255',

            'degree' => 'nullable|max:255',

            'gpa' => 'nullable|numeric|min:0|max:4',

            'start_date' => 'required|date',

            'end_date' => 'nullable|date|after_or_equal:start_date'

        ];
    }
}