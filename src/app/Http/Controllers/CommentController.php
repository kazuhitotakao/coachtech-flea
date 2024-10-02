<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::with('brand')->find($item_id);
        //ブランド関連処理
        $brand = $item->brand; // 中間テーブルを経由してbrandコレクションを返す
        $brand_name = optional($brand)->name; // ブランドのnullを許容しているため、エラー処理
        return view('comment', compact('item', 'brand_name'));
    }

    public function store(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        return redirect()->route('comment.show', ['item_id' => $item_id]);
    }
}
