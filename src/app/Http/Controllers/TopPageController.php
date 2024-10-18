<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;

class TopPageController extends Controller
{
    public function userIndex()
    {
        // 全商品取得
        $items = Item::getItems()->map(function ($item) {
            $item->thumbnail_url = $item->getThumbnailUrl();
            $item->categories_id = $item->getCategoryIds(); //各アイテムに親カテゴリを含むカテゴリーIDを付与
            return $item;
        });

        // 購入された商品の購入件数順に全商品を取得（おすすめ表示用）
        $purchased_items = Item::whereHas('purchase')->with('purchase')->get();
        $purchased_items  = $purchased_items->map(function ($purchased_item) {
            $purchased_item->categories_id = $purchased_item->getCategoryIds(); //各アイテムに親カテゴリを含むカテゴリーIDを付与
            return $purchased_item;
        });

        $category_counts = collect($purchased_items)->flatMap(function ($purchased_item) {
            return $purchased_item->categories_id; // 各アイテムの categories_id 配列をフラット化
        })->countBy() // カテゴリー ID ごとに件数をカウント
            ->sortDesc();

        $sorted_items = $items->sortByDesc(function ($item) use ($category_counts) {
            // 最初のカテゴリーIDを基準に件数が多い順にソート
            $first_category_id = $item->categories_id[0] ?? null;
            return $category_counts[$first_category_id] ?? 0;
        });

        return view('top_page', [
            'items' => $sorted_items,
        ]);
    }
}
