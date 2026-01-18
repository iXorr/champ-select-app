<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'status' => ['sometimes', 'in:Новый,Отгрузка,Доставка,Выдан,Отменен'],

            'items' => [
                'required',
                'array',
                'min:1'
            ],

            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.discount' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:100']
        ];
    }
}
