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
            ->get()
            ->map(function ($payment_detail) {
                // 各詳細情報をデコード
                $details = json_decode($payment_detail->details);
                $payment_detail->card_number = $details->card_number ?? null;
                if ($payment_detail->card_number) {
                    $payment_detail->formatted_card_number = '**** **** **** ' . substr($payment_detail->card_number, -4);
                } else {
                    $payment_detail->formatted_card_number = null;
                }
                $payment_detail->cardholder_name = $details->cardholder_name ?? null;
                $payment_detail->expiration_date = $details->expiration_date ?? null;
                return $payment_detail;
            });
    }

    // コンビニ・銀行振込の支払詳細を作成 すでにある阿合は取得する
        public static function updateOrCreateNonCredit($user_id, $payment_method_id)
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
