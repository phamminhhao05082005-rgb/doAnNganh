<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryParam = $this->route('category');
        $id = is_object($categoryParam) ? $categoryParam->id : $categoryParam;

        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ];
    }
}