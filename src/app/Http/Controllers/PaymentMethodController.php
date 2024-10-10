<?php

namespace App\Http\Controllers;

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
        $payment_details_credit = PaymentDetail::with('user', 'paymentMethod')
            ->where('user_id', Auth::id())
            ->where('payment_method_id', 1)
            ->get()
            ->map(function ($payment_detail_credit) {
                // 各要素の詳細データをデコード
                $details = json_decode($payment_detail_credit->details);
                $payment_detail_credit->card_number = $details->card_number ?? null;
                $payment_detail_credit->cardholder_name = $details->cardholder_name ?? null;
                $payment_detail_credit->expiration_date = $details->expiration_date ?? null;
                return $payment_detail_credit;
            });

        return view('payment_method', [
            'payment_details_credit' => $payment_details_credit,
            'item_id' => $request->item_id,
        ]);
    }
    public function updatePaymentMethod(Request $request) //支払方法変更処理
    {
        $item = Item::getItem($request->item_id);

        //商品画像関連処理 URL変換をモデル内で処理
        $imageUrl_thumbnail = $item->getThumbnailUrl();

        // 変更後の支払い詳細取得
        $payment_method_id = $request->payment_method_id;
        $payment_detail_id = $request->payment_detail_id;
        $payment_detail = PaymentDetail::find($payment_detail_id);
        $payment_method_name = PaymentMethod::find($payment_method_id)->name;

        // クレジットカードの場合の詳細取得
        $card_number = null;
        $cardholder_name = null;
        $expiration_date = null;
        if ($payment_method_id == 1) {
            $card_number = json_decode($payment_detail->details)->card_number;
            $cardholder_name = json_decode($payment_detail->details)->cardholder_name;
            $expiration_date = json_decode($payment_detail->details)->expiration_date;
        }

        // 支払詳細情報テーブル追加と更新
        $existing_payment_detail = PaymentDetail::with('user', 'paymentMethod')
            ->where('payment_method_id', $payment_method_id)
            ->first();
        $detail = [
            'payment_method_id' => $payment_method_id,
            'user_id' => Auth::id(),
            'details' => json_encode([
                'card_number' => $card_number,
                'cardholder_name' => $cardholder_name,
                'expiration_date' => $expiration_date,
            ])
        ];
    

        if (empty($existing_payment_detail)) {
            if ($payment_method_id == 2) {
                PaymentDetail::create($detail);
                $payment_detail_id = PaymentDetail::with('user', 'paymentMethod')
                    ->where('user_id', Auth::id())
                    ->where('payment_method_id', 2)
                    ->first()->id;
            } elseif ($payment_method_id == 3) {
                PaymentDetail::create($detail);
                $payment_detail_id = PaymentDetail::with('user', 'paymentMethod')
                    ->where('user_id', Auth::id())
                    ->where('payment_method_id', 3)
                    ->first()->id;
            }
        }
        if (!empty($existing_payment_detail)) {
            if ($payment_method_id == 2) {
                $payment_detail_id = PaymentDetail::with('user', 'paymentMethod')
                ->where('user_id', Auth::id())
                    ->where('payment_method_id', 2)
                    ->first()->id;
            } elseif ($payment_method_id == 3) {
                $payment_detail_id = PaymentDetail::with('user', 'paymentMethod')
                ->where('user_id', Auth::id())
                    ->where('payment_method_id', 3)
                    ->first()->id;
            }
        }
        
        // 支払金額計算（手数料）
        if ($payment_method_id == 2) {
            $paid_price = $item->sale_price + 500; //コンビニ手数料
            $paid_price_format = number_format($item->sale_price + 500) . '（手数料500円）';
        } elseif ($payment_method_id == 3) {
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

    public function showAddPaymentMethod(Request $request) //新規クレカ追加ページ表示
    {
        return view('payment_method_add', [
            'item_id' => $request->item_id,
        ]);
    }

    public function addPaymentMethod(Request $request) //新規クレカ追加処理
    {
        $detail = [
            'payment_method_id' => 1,
            'user_id' => Auth::id(),
            'details' => json_encode([
                'card_number' => $request->card_number,
                'cardholder_name' => $request->cardholder_name,
                'expiration_date' => $request->expiration_date,
            ])
        ];
        PaymentDetail::create($detail);
        return redirect()->route('payment_method.show', ['item_id' => $request->item_id]);
    }

    public function deletePaymentMethod(Request $request) //既存支払方法削除処理
    {
        PaymentDetail::find($request->payment_detail_id)->delete();
        return redirect()->route('payment_method.show', ['item_id' => $request->item_id]);
    }
}
