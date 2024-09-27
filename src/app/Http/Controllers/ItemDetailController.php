<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemDetailController extends Controller
{
    public function userItemDetail(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        //ブランド関連処理
        $brand = $item->brands->first(); // 中間テーブルを経由してbrandコレクションを返す
        $brand_name = $brand ? $brand->name : null; // ブランドのnullを許容しているため、エラー処理
        //カテゴリ関連処理
        $category = $item->categories->first(); // 中間テーブルを経由してcategoryコレクションを返す
        $ancestors = $category->getAncestors(); // 親カテゴリを含む全カテゴリを取得(Categoryモデル内のメソッド使用)
        $categories_name = [];
        foreach ($ancestors as $ancestor) {
            $categories_name[] = $ancestor->name;
        }
        return view('item_detail', compact('item', 'brand_name', 'categories_name'));
    }
}
