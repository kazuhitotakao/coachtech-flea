<?php

namespace App\Http\Controllers;

use App\Models\DeliveryAddress;
use App\Models\Item;
use App\Models\ResidentialAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function showPurchase(Request $request)
    {
        $item = Item::getItem($request->item_id);

        //商品画像関連処理 URL変換をモデル内で処理
        $imageUrl_thumbnail = $item->getThumbnailUrl();

        // DB住所取得
        $data_residential_address = ResidentialAddress::with('user')->where('user_id', Auth::id())->first();
        // DB配送先取得
        $data_delivery_address = DeliveryAddress::with('user')->where('user_id', Auth::id())->first();

        // 最初に $show_delivery_address を null で初期化
        $show_delivery_address = null;

        if (!empty($data_delivery_address)) {
            $show_delivery_address = $data_delivery_address;
        } elseif (!empty($data_residential_address)) {
            $show_delivery_address = $data_residential_address;
        }

        return view('purchase', [
            'item' => $item,
            'imageUrl_thumbnail' => $imageUrl_thumbnail,
            'show_delivery_address' => $show_delivery_address,
        ]);
    }

    public function purchase(Request $request)
    {
        $param = [
            "user_id" => Auth::id(),
            "postcode" => $request->postcode,
            "address" => $request->address,
            "building" => $request->building,
        ];

        $data_delivery_address = DeliveryAddress::with('user')->where('user_id', Auth::id())->first();
        if (empty($data_delivery_address)) {
            DeliveryAddress::create($param);
        } else {
            $data_delivery_address->update($param);
        }

        $item_id = $request->item_id;
        $item = Item::find($item_id);
        echo "{$item->name}を購入する決済画面";
    }
}
