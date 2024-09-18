<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCreditDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'card_holder_name',
        'card_number',
        'expiration_date',
    ];

    // 機密情報を隠す
    protected $hidden = [
        'card_holder_name',
        'card_number',
        'expiration_date',
    ];

    // 機密情報を暗号化
    protected $casts = [
        'card_holder_name' => 'encrypted',
        'card_number' => 'encrypted',
        'expiration_date' => 'encrypted',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
