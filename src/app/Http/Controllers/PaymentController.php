<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * 決済画面表示
     */
    public function create(Request $request)
    {
        return view('payment_create',  [
            'payment_detail_id' => $request->payment_detail_id,
            'paid_price' => $request->paid_price,
            'item_id' => $request->item_id,
        ]);
    }

    /**
     * 決済処理
     */
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => intval($request->paid_price),
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！(' . $e->getMessage() . ')');
        }

        $item = Item::find($request->item_id);

        // 購入処理
        Purchase::create([
            'item_id' => $item->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $item->user_id,
            'payment_detail_id' => $request->payment_detail_id,
            'paid_price' => $request->paid_price,
        ]);

        // 購入完了後のステータス変更処理
        $item->markAsSold();

        // 購入完了後、セッションから特定のデータを削除
        session()->forget(['payment_method_id', 'payment_detail_id']);
        // 購入完了後のリダイレクト処理
        return redirect('/')->with('success', "{$item->name}を購入しました。");
    }
}
