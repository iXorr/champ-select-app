<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'manufacturer' => ['required'],
            'price' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'in:кг,шт,г,л,мл'],
            'short_description' => ['required', 'max:255'],
            'description' => ['required'],
            'roast_level' => ['sometimes', 'nullable', 'string'],
            'country' => ['sometimes', 'nullable', 'string'],
            'image' => [
                'sometimes',
                'file',
                'mimes:jpg,jpeg',
                'max:2048',
            ],
        ];
    }
}
