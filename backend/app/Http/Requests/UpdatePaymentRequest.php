<?php

namespace App\Http\Requests;

use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'id' => ['required', 'exists:payments,id'],
            'status' => ['required', function($attribute, $value, $fail) {
                if (!in_array($value, PaymentStatus::getValues())) {
                    $fail('Такого статуса не существует');
                }
            }]
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Поле id обязательно',
            'id.exists' => 'Транзакции с таким id не существует',
            'status.required' => 'Поле status обязательно',
        ];
    }
}
