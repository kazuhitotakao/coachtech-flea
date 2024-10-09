<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function showPurchase(Request $request)
    {
        $item = Item::getItem($request->item_id);

        //商品画像関連処理 URL変換をモデル内で処理
        $imageUrl_thumbnail = $item->getThumbnailUrl();

        // 直近の支払い詳細取得
        $latest_payment_detail = Purchase::getLatestPaymentDetail(Auth::id());
        $payment_method_id = null;
        $payment_method_name = null;
        $payment_detail_id = null;
        $card_number = null;
        $expiration_date = null;
        if (!empty($latest_payment_detail)) {
            $payment_detail_id = $latest_payment_detail->id;
            $payment_method_id = $latest_payment_detail->payment_method_id;
            $payment_method_name = $latest_payment_detail->paymentMethod->name;
            if ($payment_method_id == 1) {
                $card_number = json_decode($latest_payment_detail->details)->card_number;
                $expiration_date = json_decode($latest_payment_detail->details)->expiration_date;
            }
        }

        // 支払金額計算（手数料）
        if ($payment_method_id === 2) {
            $paid_price = $item->sale_price + 500; //コンビニ手数料
            $paid_price_format = number_format($item->sale_price + 500) . '（手数料500円）';
        } elseif ($payment_method_id === 3) {
            $paid_price = $item->sale_price + 300; //銀行振込手数料
            $paid_price_format = number_format($item->sale_price + 300) . '（手数料300円）';
        } else {
            $paid_price = $item->sale_price; //クレカは手数料なし
            $paid_price_format = number_format($item->sale_price);
        }

        // ユーザー住所取得
        $address = Address::getUserAddress(Auth::id());

        return view('purchase', [
            'item' => $item,
            'imageUrl_thumbnail' => $imageUrl_thumbnail,
            'payment_detail_id' => $payment_detail_id,
            'payment_method_id' => $payment_method_id,
            'payment_method_name' => $payment_method_name,
            'card_number' => $card_number,
            'expiration_date' => $expiration_date,
            'paid_price' => $paid_price,
            'paid_price_format' => $paid_price_format,
            'address' => $address,
        ]);
    }

    public function purchase(Request $request)
    {
        $item = Item::find($request->item_id);

        $param = [
            "item_id" => $request->item_id,
            "buyer_id" => $item->user_id,
            "seller_id" => Auth::id(),
            "payment_detail_id" => $request->payment_detail_id,
            "address_id" => $request->address_id,
            "paid_price" => $request->paid_price,
        ];
        Purchase::create($param);
        echo "{$item->name}を購入する決済画面";
    }
}
