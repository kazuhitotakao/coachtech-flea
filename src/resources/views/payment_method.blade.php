@extends('layouts.app')

@section('js')
<script src="{{ asset('js/payment_method.js')}}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment_method.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="payment-method col-md-7">
            @csrf
            <h3 class="payment-method__title">支払い方法</h3>
            <div class="payment-method__radio">
                <input class="visually-hidden" type="radio" name="payment_method_id" id="credit" value="1" onchange="handlePaymentMethodChange(this.value);">
                <label class="payment-method__radio-label" for="credit">クレジットカード</label>
                <input class="visually-hidden" type="radio" name="payment_method_id" id="convenience" value="2" onchange="handlePaymentMethodChange(this.value);">
                <label class="payment-method__radio-label" for="convenience">コンビニ</label>
                <input class="visually-hidden" type="radio" name="payment_method_id" id="bank" value="3" onchange="handlePaymentMethodChange(this.value);">
                <label class="payment-method__radio-label" for="bank">銀行振込</label>
            </div>
            <div class="payment-method__detail-radio" id="credit-details" style="display:none;">
                <h3 class="payment-method__detail-title">クレジットカード詳細</h3>
                @foreach ($payment_details_credit as $detail)
                <div class="payment-method__detail-entry">
                    <input class="visually-hidden" type="radio" name="payment_detail_id" id="{{ $detail->id }}" value="{{ $detail->id }}" onclick="updatePaymentDetailId(this.value);">
                    <label class="payment-method__detail-entry-label" for="{{ $detail->id }}">
                        <div class="payment-method__detail-wrapper">
                            <table class="payment-method__detail-table">
                                <tr class="payment-method__detail-row">
                                    <th class="payment-method__detail-label">カード番号</th>
                                    <td class="payment-method__detail-data">{{ $detail->card_number }}</td>
                                </tr>
                                <tr class="payment-method__detail-row">
                                    <th class="payment-method__detail-label">名義人</th>
                                    <td class="payment-method__detail-data">{{ $detail->cardholder_name }}</td>
                                </tr>
                                <tr class="payment-method__detail-row">
                                    <th class="payment-method__detail-label">有効期限</th>
                                    <td class="payment-method__detail-data">{{ $detail->expiration_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </label>
                    <form class="payment-method__delete-form" action="{{ route('payment_method.delete', ['item_id' => $item_id]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="payment_detail_id" value="{{ $detail->id }}">
                        <button class="payment-method__delete-button" type="submit">削除</button>
                    </form>
                </div>
                @endforeach
                <form class="payment-method__add-form" action="{{ route('payment_method.add.show', ['item_id' => $item_id]) }}" method="get">
                    <button class="payment-method__add-button" type="submit">カードを追加する</button>
                </form>
            </div>
        </div>
        <div class="payment-method__update col-md-5">
            <form class="payment-method__update-form" action="{{ route('payment_method.update', ['item_id' => $item_id]) }}" method="POST">
                @csrf
                <input type="hidden" id="payment-method-id-input" name="payment_method_id" value="">
                <input type="hidden" id="payment-detail-id-input" name="payment_detail_id" value="">
                <button class="payment-method__update-button" type="submit">変更する</button>
            </form>
        </div>
    </div>

    @endsection