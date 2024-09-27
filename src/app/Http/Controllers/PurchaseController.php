<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function showPurchase(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        return view('purchase', compact('item'));
    }

    public function purchase(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        echo "{$item->name}を購入する決済画面";
    }
}
