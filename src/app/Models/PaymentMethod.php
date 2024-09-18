<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * ユーザーとの多対多リレーション (users: 多対多)
     * 中間テーブル payment_method_user を介してユーザーとリレーション
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'payment_method_user')
        ->withTimestamps();
    }
}
