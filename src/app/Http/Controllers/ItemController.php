<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        return view('item_create');
    }

    public function upload(Request $request)
    {
        // セッションから既存の画像パスリストを取得
        $imagePaths = session()->get('uploaded_images', []);

        // 新しい画像を保存し、パスをリストに追加
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images/items');
                $imagePaths[] = $path;
            }
        }

        // 更新されたリストをセッションに保存
        session()->put('uploaded_images', $imagePaths);

        // 画像プレビューページにリダイレクト
        return redirect()->route('item.create');
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        // dd($request->name);
        // 1 出品し商品レコードを作成 （item_idの作成）
        Item::create([
            'name' => $request->name,
            'user_id' => $user_id,
        ]);
        $item_id = Item::with('user')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->first()->id;
        // 2 画像一覧をitem_imagesに保存 (item_image_idの作成)
        $image_paths = session()->get('uploaded_images', []);
        foreach ($image_paths as $image_path) {
            ItemImage::create([
                'item_id' => $item_id,
                'image_path' => $image_path,
            ]);
        }
        // 3-1 サムネイルに選択した画像のitem_image_idを取得
        $item_images = ItemImage::where('item_id', $item_id)->get();
        $thumbnail_item_image_id = $item_images[$request->thumbnail_index]->id;
        // 3-2 サムネイルに選択した画像のitem_image_idを出品した商品に保存、更新。
        $item = Item::find($item_id);
        $item->item_image_id = $thumbnail_item_image_id;
        $item->save();

        session()->forget('uploaded_images');
        return redirect('/');
    }
}
