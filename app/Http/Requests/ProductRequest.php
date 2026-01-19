<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'manufacturer' => ['required'],

            'image' => [
                'sometimes',
                'file',
                'mimes:jpg,jpeg',
                'max:2048'
            ],

            'price' => ['required', 'integer'],
            'unit' => ['required', 'in:кг,шт,гр,л,мл'],

            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['required'],

            'features' => [
                'sometimes',
                'array'
            ],
            
            'features.*.title' => ['required'],
            'features.*.value' => ['required'],
        ];
    }
}
