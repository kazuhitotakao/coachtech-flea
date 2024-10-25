<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'thumbnail_id' => ['required'],
            'user_name' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'digits:7'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'thumbnail_id.required' => 'サムネイル画像を選択してください。',
            'user_name.required' => 'ユーザー名を入力してください。',
            'user_name.string' => 'ユーザー名は文字列で入力してください。',
            'user_name.max' => 'ユーザー名は255文字以内で入力してください。',
            'postcode.required' => '郵便番号を入力してください。',
            'postcode.digits' => '郵便番号は数字7桁で入力してください。',
            'address.required' => '住所を入力してください。',
            'address.string' => '住所は文字列で入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'building.string' => '建物名は文字列で入力してください。',
            'building.max' => '建物名は255文字以内で入力してください。',
        ];
    }
}