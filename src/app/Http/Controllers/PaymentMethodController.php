<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodAddRequest;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\Address;
use App\Models\Item;
use App\Models\PaymentDetail;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function showPaymentMethod(Request $request) //支払方法変更ページ表示
    {
        return view('payment_method', [
            'item_id' => $request->item_id,
        ]);
    }
    public function updatePaymentMethod(PaymentMethodRequest $request) //支払方法変更処理
    {
        $item = Item::getItem($request->item_id);
        $payment_method_id = $request->payment_method_id;

        // 支払詳細テーブルに詳細を登録し、支払詳細IDを得る
        $payment_detail_id = PaymentDetail::updateOrCreate(Auth::id(), $payment_method_id);

        // 支払金額計算（手数料）
        $paid_price_info = $item->calculatePaidPrice($payment_method_id);

        // ユーザー住所取得
        $address = Address::getUserAddress(Auth::id());
        $address_id = $address?->id ?? null; // $address が null なら null を返す

        // 支払方法の情報をセッションに保存
        session([
            'payment_method_id' => $payment_method_id,
            'payment_detail_id' => $payment_detail_id
        ]);

        return view('purchase', [
            'item' => $item,
            'image_url_thumbnail' => $item->getThumbnailUrl(),
            'payment_detail_id' => $payment_detail_id,
            'payment_method_id' => $payment_method_id,
            'payment_method_name' => PaymentMethod::find($payment_method_id)->name,
            'paid_price' => $paid_price_info['paid_price'],
            'paid_price_format' => $paid_price_info['paid_price_format'],
            'address' => $address,
            'address_id' => $address_id,
        ]);
    }
}
