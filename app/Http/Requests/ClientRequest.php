<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'regex:/\\S+\\s\\S+/'],
            
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'login')->ignore($this->route('user'))
            ],
            
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/\\+7\\d{10}/'],
            'note' => ['nullable'],
        ];
    }
}
