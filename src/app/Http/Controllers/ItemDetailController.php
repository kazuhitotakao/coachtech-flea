<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemDetailController extends Controller
{
    public function userItemDetail(Request $request)
    {
        $item = Item::getItem($request->item_id);

        //カテゴリ関連処理
        $category = $item->categories->first(); // 中間テーブルを経由してcategoryコレクションを返す
        $ancestors = $category->getAncestors(); // 親カテゴリを含む全カテゴリを取得(Categoryモデル内のメソッド使用)
        $categories_name = [];
        foreach ($ancestors as $ancestor) {
            $categories_name[] = $ancestor->name;
        }
        
        //商品画像関連処理 URL変換をモデル内で処理
        $imagesUrl = $item->getImageUrls();
        $imageUrl_thumbnail = $item->getThumbnailUrl();

        return view('item_detail', [
            'item' => $item,
            'brand_name' => optional($item->brand)->name,
            'categories_name' => $categories_name,
            'imagesUrl' => $imagesUrl,
            'imageUrl_thumbnail' => $imageUrl_thumbnail,
            'favorites_count' => $item->favorites->count(),
            'comments_count' => $item->comments->count(),
        ]);
    }
}
