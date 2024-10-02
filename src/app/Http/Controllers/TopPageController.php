<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Support\Facades\Storage;

class TopPageController extends Controller
{
    public function userIndex()
    {
        $items = Item::getItems();
        $imagesUrl = [];

        foreach ($items as $item) {
            //itemの画像idを取得
            $itemImageId = $item->item_image_id;
            //item_Imagesテーブルから画像パスを取得
            $imagePath = ItemImage::find($itemImageId)->image_path;
            if (strpos($imagePath, 'http') === 0) {
                // 公開URLの場合
                $imagesUrl[] = $imagePath;
            } else {
                // ストレージ内の画像の場合
                $imagesUrl[] = Storage::url($imagePath);
            }
        }
        return view('top_page', compact('items', 'imagesUrl'));
    }

    public function guestIndex()
    {
        $items = Item::with(['condition', 'brand'])->get();
        $imagesUrl = [];

        foreach ($items as $item) {
            //itemの画像idを取得
            $itemImageId = $item->item_image_id;
            //item_Imagesテーブルから画像パスを取得
            $imagePath = ItemImage::find($itemImageId)->image_path;
            if (strpos($imagePath, 'http') === 0) {
                // 公開URLの場合
                $imagesUrl[] = $imagePath;
            } else {
                // ストレージ内の画像の場合
                $imagesUrl[] = Storage::url($imagePath);
            }
        }
        return view('guest.top_page', compact('items', 'imagesUrl'));
    }
}
