<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'buyer_id',
        'seller_id',
        'payment_detail_id',
        'address_id',
        'paid_price'
    ];

    public static function getLatestPaymentDetail($user_id)
    {
        $purchase = self::with('paymentDetail')
        ->where('buyer_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($purchase) {
            return $purchase->paymentDetail;
        } else {
            return null;
        }
    }

    public static function getPaymentDetailsForUser($user_id)
    {
        $latest_payment_detail = self::getLatestPaymentDetail($user_id);
        $payment_details = [
            'payment_detail_id' => null,
            'payment_method_id' => null,
            'payment_method_name' => null,
            'card_number' => null,
            'expiration_date' => null,
        ];

        if ($latest_payment_detail) {
            $payment_details['payment_detail_id'] = $latest_payment_detail->id;
            $payment_details['payment_method_id'] = $latest_payment_detail->payment_method_id;
            $payment_details['payment_method_name'] = $latest_payment_detail->paymentMethod->name;

            if ($payment_details['payment_method_id'] == 1) {
                $details = json_decode($latest_payment_detail->details);
                $payment_details['card_number'] = $details->card_number;
                $payment_details['expiration_date'] = $details->expiration_date;
            }
        }

        return $payment_details;
    }

    /**
     * 購入に関連する商品を取得。
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * 購入者（ユーザー）を取得。
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * 出品者（ユーザー）を取得。
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * 支払詳細を取得。
     */
    public function paymentDetail()
    {
        return $this->belongsTo(PaymentDetail::class);
    }

    /**
     * 配送先住所を取得。
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
