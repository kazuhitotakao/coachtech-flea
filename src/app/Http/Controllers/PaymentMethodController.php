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
        // クレジットカードの支払い詳細を取得し、各詳細情報をデコード
        $payment_details_credit = PaymentDetail::getPaymentDetails(Auth::id(), 1);

        return view('payment_method', [
            'payment_details_credit' => $payment_details_credit,
            'item_id' => $request->item_id,
        ]);
    }
    public function updatePaymentMethod(PaymentMethodRequest $request) //支払方法変更処理
    {
        $item = Item::getItem($request->item_id);
        $payment_method_id = $request->payment_method_id;
        $payment_detail_id = $request->payment_detail_id;

        // クレジットカードの場合の処理
        if ($payment_method_id == 1) {
            $payment_detail = PaymentDetail::find($request->payment_detail_id);
            $card_number = json_decode($payment_detail->details)->card_number;
            $expiration_date = json_decode($payment_detail->details)->expiration_date;
        } else {
            // コンビニ払いまたは銀行振込の場合の処理
            $payment_detail_id = PaymentDetail::updateOrCreateNonCredit(Auth::id(), $payment_method_id);
            $card_number = $expiration_date = null;
        }

        // 支払金額計算（手数料）
        $paid_price_info = $item->calculatePaidPrice($payment_method_id);

        // ユーザー住所取得
        $address = Address::getUserAddress(Auth::id());

        return view('purchase', [
            'item' => $item,
            'image_url_thumbnail' => $item->getThumbnailUrl(),
            'payment_detail_id' => $payment_detail_id,
            'payment_method_id' => $payment_method_id,
            'payment_method_name' => PaymentMethod::find($payment_method_id)->name,
            'formatted_card_number' => '**** **** **** ' . substr($card_number, -4),
            'expiration_date' => $expiration_date,
            'paid_price' => $paid_price_info['paid_price'],
            'paid_price_format' => $paid_price_info['paid_price_format'],
            'address' => $address,
        ]);
    }

    public function showAddPaymentMethod(Request $request) //新規クレカ追加ページ表示
    {
        return view('payment_method_add', [
            'item_id' => $request->item_id,
        ]);
    }

    public function addPaymentMethod(PaymentMethodAddRequest $request) //新規クレカ追加処理
    {
        PaymentDetail::create([
            'payment_method_id' => 1,
            'user_id' => Auth::id(),
            'details' => json_encode([
                'card_number' => $request->card_number,
                'cardholder_name' => $request->cardholder_name,
                'expiration_date' => $request->expiration_year . '-' . $request->expiration_month,
            ])
        ]);
        return redirect()->route('payment_method.show', ['item_id' => $request->item_id]);
    }

    public function deletePaymentMethod(Request $request) //既存支払方法削除処理
    {
        PaymentDetail::find($request->payment_detail_id)->delete();
        return redirect()->route('payment_method.show', ['item_id' => $request->item_id]);
    }
}
