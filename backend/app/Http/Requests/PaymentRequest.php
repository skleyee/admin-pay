<?php

namespace App\Http\Requests;

use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'login'    => ['required', 'exists:users,login'],
            'details'  => ['required', 'string', 'min:13', 'max:19'],
            'amount'   => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'status'   => ['required', function($attribute, $value, $fail) {
                if (!in_array($value, PaymentStatus::getValues())) {
                    $fail('Такого статуса не существует');
                }
            }]
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'Поле login обязательно',
            'login.exists'   => 'Не существует пользователя с таким логином',
            'details.required' => 'Поле details обязательно',
            'details.string' => 'Поле details должно быть строкой',
            'details.min' => 'Минимум 13 символов',
            'details.max' => 'Максимум 19 символов',
            'amount.required' => 'Поле amount обязательно',
            'amount.numeric' => 'Поле amount должно быть числовым значением',
            'amount.min' => 'Сумма не может быть меньше нуля',
            'currency.required' => 'Поле currency обязательно',
            'currency.string' => 'Поле currency должно быть строкой',
            'currency.size' => 'Поле должно быть в формате ISO - содержать 3 символа',
            'status.required' => 'Поле status обязательно',
        ];
    }
}
