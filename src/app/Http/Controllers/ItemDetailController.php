<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemDetailController extends Controller
{
    public function userItemDetail(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::getItem($item_id);
        //ブランド関連処理
        $brand = $item->brand; // brandコレクションを返す
        $brand_name = optional($brand)->name; // ブランドのnullを許容しているため、エラー処理
        //カテゴリ関連処理
        $category = $item->categories->first(); // 中間テーブルを経由してcategoryコレクションを返す
        $ancestors = $category->getAncestors(); // 親カテゴリを含む全カテゴリを取得(Categoryモデル内のメソッド使用)
        $categories_name = [];
        foreach ($ancestors as $ancestor) {
            $categories_name[] = $ancestor->name;
        }
        //商品画像関連処理
        //サムネイル画像
        $itemImageId = $item->item_image_id;
        $imagePath_thumbnail = ItemImage::find($itemImageId)->image_path;
        if (strpos($imagePath_thumbnail, 'http') === 0) {
            // 公開URLの場合
            $imageUrl_thumbnail = $imagePath_thumbnail;
        } else {
            // ストレージ内の画像の場合
            $imageUrl_thumbnail = Storage::url($imagePath_thumbnail);
        }
        //画像一覧
        $itemImages = $item->itemImages;
        $imagesUrl = [];
        foreach ($itemImages as $itemImage) {
            //item_Imagesテーブルから画像パスを取得
            $imagePath = $itemImage->image_path;
            if (strpos($imagePath, 'http') === 0) {
                // 公開URLの場合
                $imagesUrl[] = $imagePath;
            } else {
                // ストレージ内の画像の場合
                $imagesUrl[] = Storage::url($imagePath);
            }
        }
        // お気に入りの総数
        $favorites_count = Favorite::where('item_id', $item_id)->count();

        // コメントの総数
        $comments_count = Comment::where('item_id', $item_id)->count();

        return view('item_detail', [
            'item' => $item,
            'brand_name' => $brand_name,
            'categories_name' => $categories_name,
            'imagesUrl' => $imagesUrl,
            'imageUrl_thumbnail' => $imageUrl_thumbnail,
            'favorites_count' => $favorites_count,
            'comments_count' => $comments_count,
        ]);
    }
}
