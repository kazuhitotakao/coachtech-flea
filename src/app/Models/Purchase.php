<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'buyer_id',
        'seller_id',
        'payment_detail_id',
        'paid_price'
    ];

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
    public function PaymentDetail()
    {
        return $this->belongsTo(PaymentDetail::class);
    }

}
