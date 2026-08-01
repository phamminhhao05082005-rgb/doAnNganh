<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCVExperienceRequest
extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'company_name'=>'required|max:255',

            'position'=>'required|max:255',

            'start_date'=>'required|date',

            'end_date'=>'nullable|date|after_or_equal:start_date',

            'description'=>'nullable'

        ];
    }
}