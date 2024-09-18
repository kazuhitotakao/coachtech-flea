<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_id',
        'condition_id',
        'brand_id',
        'category_id',
        'overview',
        'amount',
        'user_id',
    ];

    /**
     * ユーザーとのリレーション (多対1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * アイテム画像とのリレーション (1対多)
     */
    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

    /**
     * 状態テーブルとのリレーション (多対1)
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * ブランドとのリレーション (多対多)
     */
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_item')
            ->withTimestamps();
    }

    /**
     * カテゴリとのリレーション (多対多)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item')
            ->withTimestamps();
    }

    /**
     * コメントとのリレーション (多対多)
     */
    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments')
            ->withPivot('comment')
            ->withTimestamps();
    }

    /**
     * お気に入りとのリレーション (多対多)
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * 購入履歴とのリレーション (多対多)
     */
    public function purchases()
    {
        return $this->belongsToMany(User::class, 'purchases')
            ->withTimestamps();
    }
}
