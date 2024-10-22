<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
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
        $user_id = Auth::id();

        //商品画像関連処理 URL変換をモデル内で処理
        $image_url_thumbnail = $item->getThumbnailUrl();

        // 直近の支払い詳細取得
        $payment_details = Purchase::getPaymentDetailsForUser($user_id);

        // 支払金額計算（手数料）
        $paid_price_info = $item->calculatePaidPrice($payment_details['payment_method_id']);

        // ユーザー住所取得
        $address = Address::getUserAddress(Auth::id());

        return view('purchase', [
            'item' => $item,
            'image_url_thumbnail' => $image_url_thumbnail,
            'payment_detail_id' => $payment_details['payment_detail_id'],
            'payment_method_id' => $payment_details['payment_method_id'],
            'payment_method_name' => $payment_details['payment_method_name'],
            'formatted_card_number' => '**** **** **** ' . substr($payment_details['card_number'], -4),
            'expiration_date' => $payment_details['expiration_date'],
            'paid_price' => $paid_price_info['paid_price'],
            'paid_price_format' => $paid_price_info['paid_price_format'],
            'address' => $address,
        ]);
    }

    public function purchase(PurchaseRequest $request)
    {
        $item = Item::find($request->item_id);

        // 購入処理
        Purchase::create([
            'item_id' => $item->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $item->user_id,
            'payment_detail_id' => $request->payment_detail_id,
            'address_id' => $request->address_id,
            'paid_price' => $request->paid_price,
        ]);

        // 購入完了後のステータス変更処理
        $item->markAsSold();

        // 購入完了後のリダイレクト処理
        return redirect('/')->with('success', "{$item->name}を購入しました。");
    }
}
