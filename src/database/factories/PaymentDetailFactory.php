<?php

namespace Database\Factories;

use App\Models\PaymentDetail;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentDetailFactory extends Factory
{
    // このファクトリーで使用するモデルの指定
    protected $model = PaymentDetail::class;

    public function definition()
    {
        return [
            'payment_method_id' => PaymentMethod::factory(), // 支払い方法ID（PaymentMethodモデルから自動生成）
            'user_id' => User::factory(), // ユーザーID（Userモデルから自動生成）
            'details' => json_encode(['additional_info' => 'Test data']) // JSON形式で詳細情報を保存
        ];
    }
}
