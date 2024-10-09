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
