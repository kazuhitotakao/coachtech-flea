<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function resultSearch(Request $request)
    {
        $items = Item::with(['categories.parentCategory', 'brand'])
            ->search($request->keyword)
            ->get()
            ->map(function ($item) {
                // 各アイテムにthumbnail_url属性を追加
                $item->thumbnail_url = $item->getThumbnailUrl();
                return $item;
            });

        // ユーザーがログインしているかどうかで表示するビューを変更
        $view = Auth::check() ? 'top_page' : 'guest.top_page';
        return view($view, compact('items'));
    }
}
