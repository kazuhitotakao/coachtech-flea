<?php

namespace App\Http\Controllers;

use App\Models\Item;

class MyPageController extends Controller
{
    public function index()
    {
        $items = Item::getItems()->map(function ($item) {
            // 各アイテムにthumbnailUrl属性を追加
            $item->thumbnailUrl = $item->getThumbnailUrl();
            return $item;
        });
        return view('my_page', compact('items'));
    }
}
