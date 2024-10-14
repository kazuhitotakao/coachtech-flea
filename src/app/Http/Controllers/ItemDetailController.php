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
        $categories_name = $item->getCategoryNames();
        
        //商品画像関連処理 URL変換をモデル内で処理
        $imageUrls = $item->getImageUrls();
        $imageUrl_thumbnail = $item->getThumbnailUrl();

        return view('item_detail', [
            'item' => $item,
            'brand_name' => optional($item->brand)->name,
            'categories_name' => $categories_name,
            'imageUrls' => $imageUrls,
            'imageUrl_thumbnail' => $imageUrl_thumbnail,
            'favorites_count' => $item->favorites->count(),
            'comments_count' => $item->comments->count(),
        ]);
    }
}
