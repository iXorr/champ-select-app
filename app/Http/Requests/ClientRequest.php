<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'regex:/^\\s*\\S+\\s+\\S+/u'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'phone' => ['required'],
            'note' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
