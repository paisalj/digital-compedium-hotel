<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Validasi untuk translations (array)
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.slug' => 'required|string|max:255',

            // Validasi field lainnya
            'icon'      => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'translations.*.name' => 'Nama Kategori',
            'translations.*.slug' => 'Slug',
            'icon'                => 'Icon',
            'is_active'           => 'Status',
        ];
    }
}