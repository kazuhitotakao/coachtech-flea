<?php

namespace App\Http\Controllers;

use App\Models\Item;

class TopPageController extends Controller
{
    public function userIndex()
    {
        $items = Item::getItems()->map(function ($item) {
            // 各アイテムにthumbnail_url属性を追加
            $item->thumbnail_url = $item->getThumbnailUrl();
            return $item;
        });
        return view('top_page', compact('items'));
    }
}
