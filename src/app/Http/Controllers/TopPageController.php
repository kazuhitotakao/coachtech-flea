<?php

namespace App\Http\Controllers;

use App\Models\Item;

class TopPageController extends Controller
{
    public function userIndex()
    {
        $items = Item::getItems()->map(function ($item) {
            // 各アイテムにthumbnailUrl属性を追加
            $item->thumbnailUrl = $item->getThumbnailUrl();
            return $item;
        });
        return view('top_page', compact('items'));
    }
}
