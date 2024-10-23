<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'user_id',
        'details',
    ];

    // 特定ユーザーと支払い方法の支払い詳細を取得
    public static function getPaymentDetails($user_id, $payment_method_id)
    {
        return self::where('user_id', $user_id)
            ->where('payment_method_id', $payment_method_id)
            ->get();
    }

    // 支払詳細を作成 すでにある場合は取得する
        public static function updateOrCreate($user_id, $payment_method_id)
    {
        $detail = self::firstOrCreate(
            ['user_id' => $user_id, 'payment_method_id' => $payment_method_id],
            ['details' => json_encode([])]  // 初期値で空のJSONをセット
        );

        return $detail->id;
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
