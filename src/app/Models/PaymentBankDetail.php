<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'account_name',
        'account_number',
        'bank_name',
        'branch_name',
    ];

    // 機密情報を隠す
    protected $hidden = [
        'account_name',   // 口座名義を非表示
        'account_number', // 口座番号を非表示
    ];

    // 機密情報を暗号化
    protected $casts = [
        'account_name' => 'encrypted',
        'account_number' => 'encrypted',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
