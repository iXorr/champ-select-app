<?php

namespace App\Http\Requests;

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
            'contact_name' => ['required', 'regex:/^[А-Яа-яЁё\\s-]+$/u', 'max:120'],
            'contact_phone' => ['required', 'regex:/^\\+7\\(\\d{3}\\)-\\d{3}-\\d{2}-\\d{2}$/'],
            'contact_email' => ['nullable', 'email', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'payment_method' => ['required', Rule::in(['cash', 'card'])],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'contact_name.regex' => 'ФИО должно содержать только кириллицу, пробелы и дефисы.',
            'contact_phone.regex' => 'Введите номер в формате +7(XXX)-XXX-XX-XX.',
            'preferred_time.date_format' => 'Время необходимо указать в формате ЧЧ:ММ.',
        ];
    }
}
