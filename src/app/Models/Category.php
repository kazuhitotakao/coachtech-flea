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
     * このカテゴリとそのすべての親カテゴリを取得します。
     */
    public function getAncestors()
    {
        $ancestors = collect();
        $category = $this; // 現在のカテゴリから開始

        // 再帰的に親カテゴリを取得
        while ($category) {
            $ancestors->prepend($category);
            $category = $category->parentCategory; // 関連を使って親カテゴリを取得
        }

        return $ancestors;
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
