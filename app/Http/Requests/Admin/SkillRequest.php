<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $skillParam = $this->route('skill');
        $id = is_object($skillParam) ? $skillParam->id : $skillParam;

        return [
            'name' => 'required|string|max:255|unique:skills,name,' . $id,
        ];
    }
}