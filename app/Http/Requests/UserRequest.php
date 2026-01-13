<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'login' => [
                'required',
                Rule::unique('users', 'login')->ignore($this->route('user')),
            ],
            'role' => ['required', 'in:admin,manager'],
            'password' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'confirmed',
                'min:4',
            ],
        ];
    }
}
