<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|max:100',

            'native_name' => 'required|max:100',

'code' => 'required|max:10|unique:languages,code,' . $this->language->id,
            'flag' => 'nullable|max:20',

            'sort_order' => 'required|integer|min:1',

            'is_active' => 'required|boolean',

            'is_default' => 'nullable|boolean',

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Nama bahasa wajib diisi.',

            'native_name.required' => 'Nama asli wajib diisi.',

            'code.required' => 'Kode bahasa wajib diisi.',

            'code.unique' => 'Kode bahasa sudah digunakan.',

            'sort_order.required' => 'Urutan wajib diisi.',

            'sort_order.integer' => 'Urutan harus berupa angka.',

        ];
    }
}