<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function guestIndex()
    {
        $items = Item::getItems()->map(function ($item) {
            // 各アイテムにthumbnailUrl属性を追加
            $item->thumbnailUrl = $item->getThumbnailUrl();
            return $item;
        });
        return view('guest.top_page', compact('items'));
    }

    public function guestItemDetail(Request $request)
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
        $imageUrls = $item->getImageUrls();
        $imageUrl_thumbnail = $item->getThumbnailUrl();

        return view('guest.item_detail', [
            'item' => $item,
            'brand_name' => optional($item->brand)->name,
            'categories_name' => $categories_name,
            'imageUrls' => $imageUrls,
            'imageUrl_thumbnail' => $imageUrl_thumbnail,
            'favorites_count' => $item->favorites->count(),
            'comments_count' => $item->comments->count(),
        ]);
    }

    public function unauthorizedAccess()
    {
        return view('guest.unauthorized_access');
    }
}
