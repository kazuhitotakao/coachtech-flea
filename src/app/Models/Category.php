<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * アイテムとの多対多リレーション (Item: 多対多)
     * 中間テーブル category_item を介して関連付けられる
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'category_item')
        ->withTimestamps();
    }

    //カテゴリの階層構造を管理するための自己リレーション
    /**
     * 親カテゴリとのリレーション (Category: 1対多)
     * 親カテゴリを取得するリレーション
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * 子カテゴリとのリレーション (Category: 1対多)
     * このカテゴリに属する子カテゴリを取得するリレーション
     */
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
