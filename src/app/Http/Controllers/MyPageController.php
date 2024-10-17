<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function indexListed()
    {
        $items = Item::getListedItems()->map(function ($item) {
            // 各アイテムにthumbnail_url属性を追加
            $item->thumbnail_url = $item->getThumbnailUrl();
            return $item;
        });

        //ユーザーにthumbnail_url属性を追加
        $user = User::getUser(Auth::id());
        $user->thumbnail_url = $user->getThumbnailUrl();

        return view('my_page_listed', compact('items', 'user'));
    }

    public function indexPurchased()
    {
        $items = Item::getPurchasedItems()->map(function ($item) {
            // 各アイテムにthumbnail_url属性を追加
            $item->thumbnail_url = $item->getThumbnailUrl();
            return $item;
        });

        //ユーザーにthumbnail_url属性を追加
        $user = User::getUser(Auth::id());
        $user->thumbnail_url = $user->getThumbnailUrl();

        return view('my_page_purchased', compact('items', 'user'));
    }
}
