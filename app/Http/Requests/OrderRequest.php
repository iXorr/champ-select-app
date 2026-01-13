<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'exists:clients,id',
            ],
            'status' => ['sometimes', Rule::in(Order::STATUSES)],
            'shipped_at' => ['sometimes', 'nullable', 'date'],
            'items' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'array',
                'min:1',
            ],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.discount' => ['sometimes', 'integer', 'min:0', 'max:100'],
        ];
    }
}
