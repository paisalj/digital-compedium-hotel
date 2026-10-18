<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Apakah user boleh mengakses request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi.
     */
    public function rules(): array
    {
        return [

            'icon' => [
                'nullable',
                'string',
                'max:255',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'translations' => [
                'required',
                'array',
            ],

            'translations.*.name' => [
                'required',
                'string',
                'max:255',
            ],

            'translations.*.slug' => [
                'nullable',
                'string',
                'max:255',
            ],

        ];
    }

    /**
     * Nama field.
     */
    public function attributes(): array
    {
        return [

            'translations.*.name' => 'Nama Kategori',

            'translations.*.slug' => 'Slug',

            'icon' => 'Icon',

            'is_active' => 'Status',

        ];
    }
}