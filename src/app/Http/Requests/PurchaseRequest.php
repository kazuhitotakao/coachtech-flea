<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'address_id' => ['required', 'exists:addresses,id'],
            'payment_detail_id' => ['required', 'exists:payment_details,id'],
        ];
    }

    public function messages()
    {
        return [
            'address_id.*' => '配送先を設定してください。',
            'payment_detail_id.*' => '支払い方法を設定してください。',
        ];
    }
}
