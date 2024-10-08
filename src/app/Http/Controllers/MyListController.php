<?php

namespace App\Http\Controllers;

use App\Models\Item;

class MyListController extends Controller
{
    public function index()
    {
        $items = Item::getLikeItems()->map(function ($item) {
            // 各アイテムにthumbnailUrl属性を追加
            $item->thumbnailUrl = $item->getThumbnailUrl();
            return $item;
        });
        return view('my_list', compact('items'));
    }
}
