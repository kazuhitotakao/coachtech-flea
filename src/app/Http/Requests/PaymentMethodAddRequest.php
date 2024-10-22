<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'card_number' => ['required'],
            'cardholder_name' => ['required', 'string','max:100'],
            'expiration_month' => ['required'],
            'expiration_year' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // カード番号のバリデーション
            $formatted_card_number = str_replace(' ', '', $this->card_number);
            if (!is_numeric($formatted_card_number) || strlen($formatted_card_number) < 13 || strlen($formatted_card_number) > 19) {
                $validator->errors()->add('card_number', 'カード番号は数値のみで、13桁から19桁の間である必要があります。');
            }
        });
    }

    public function messages()
    {
        return [
            'card_number.required' => 'カード番号を入力してください。',
            'cardholder_name.required' => 'カード名義を入力してください。',
            'card_number.string' => 'カード名義は文字列で入力してください。',
            'card_number.max' => 'カード名義は100文字以内で入力してください。',
            'expiration_month.required' => 'カード有効期限（月）を入力してください。',
            'expiration_year.required' => 'カード有効期限（年）を入力してください。',
        ];
    }
}
