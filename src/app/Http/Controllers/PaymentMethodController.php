<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function showPaymentMethod() //支払方法変更ページ表示
    {
        return view('payment_method');
    }
    public function updatePaymentMethod() //支払方法変更処理
    {
        return view('purchase');
    }

    //支払方法変更ページから以下の処理は派生する
    
    public function showAddPaymentMethod() //新規支払方法追加ページ表示
    {
        return view('payment_method_add');
    }

    public function addPaymentMethod() //新規支払方法追加処理
    {
        return view('payment_method');
    }

    public function deletePaymentMethod() //既存支払方法削除処理
    {
        return view('payment_method');
    }

}
