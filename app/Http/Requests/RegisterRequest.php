<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'min:4', 'max:40', 'regex:/^[A-Za-z0-9_]+$/', 'unique:users,login'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'full_name' => ['required', 'regex:/^[А-Яа-яЁё\\s-]+$/u', 'max:120'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'phone' => ['required', 'regex:/^\\+7\\(\\d{3}\\)-\\d{3}-\\d{2}-\\d{2}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.regex' => 'Логин может содержать только латинские буквы, цифры и символ _.',
            'full_name.regex' => 'ФИО должно содержать только кириллицу, пробелы и дефисы.',
            'phone.regex' => 'Введите номер в формате +7(XXX)-XXX-XX-XX.',
        ];
    }
}
