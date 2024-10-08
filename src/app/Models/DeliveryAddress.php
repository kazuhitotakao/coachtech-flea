<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postcode',
        'address',
        'building',
    ];

    /**
     * 郵便番号を日本のフォーマット〒xxx-xxxx に変換
     */
    public function getFormattedPostalCode()
    {
        return '〒' . substr($this->postcode, 0, 3) . '-' . substr($this->postcode, 3);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
