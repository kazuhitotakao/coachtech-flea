<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'comment',
    ];

    /**
     * ユーザーとのリレーション (User: 多対多)
     * 中間テーブル comments でリレーションを管理
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * アイテムとのリレーション (Item: 多対多)
     * 中間テーブル comments でリレーションを管理
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
