<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * アイテムとの多対多リレーション (Item: 多対多)
     * 中間テーブル brand_item を介して関連付けられる
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'brand_item')
            ->withTimestamps();
    }
}
