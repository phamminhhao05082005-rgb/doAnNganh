<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
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
            'school' => [
                'required',
                'string',
                'max:255',
            ],

            'major' => [
                'required',
                'string',
                'max:255',
            ],

            'start_year' => [
                'required',
                'integer',
                'digits:4',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'digits:4',
                'gte:start_year',
            ],
        ];
    }
}