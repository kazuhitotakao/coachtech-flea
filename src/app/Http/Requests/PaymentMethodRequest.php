<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
            'payment_method_id' => ['required'],
            'payment_detail_id' => ['sometimes', 'required_if:payment_method_id,1'],  // payment_method_idが1の場合に必須
        ];
    }

    public function messages()
    {
        return [
            'payment_method_id.required' => '支払い方法を選択してください。',
            'payment_detail_id.required_if' => '支払い方法がクレジットカードの場合、カードの詳細を入力してください。'
        ];
    }
}
