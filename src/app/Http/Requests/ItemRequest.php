<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'thumbnail_index' => ['required'],
            'category_ids' => ['required'],
            'condition_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sale_price' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 販売価格のバリデーション
            $formatted_sale_price = str_replace(',', '', $this->sale_price);
            if (!is_numeric($formatted_sale_price) || floatval($formatted_sale_price) < 1 || floatval($formatted_sale_price) > 9999999.99) {
                $validator->errors()->add('sale_price', '販売価格は、1 ~ 9,999,999円の範囲内で入力してください。');
            }
        });
    }


    public function messages()
    {
        return [
            'thumbnail_index.required' => 'サムネイル画像を選択してください。',
            'category_ids.required' => 'カテゴリーを選択してください。',
            'condition_id.required' => '商品の状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'name.string' => '商品名は文字列で入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'description.string' => '商品の説明は文字列で入力してください。',
            'sale_price.required' => '販売価格を入力してください。',
            'sale_price.numeric' => '販売価格は数字で入力してください。',
            'sale_price.min' => '販売価格は0以上で入力してください。',
            'sale_price.max' => '販売価格は9,999,999.99円以下で入力してください。',
        ];
    }
}
