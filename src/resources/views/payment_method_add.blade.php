@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment_method_add.css') }}">
@endsection

@section('content')

<div class="payment-method">
    <div class="payment-method__title">
        <h2>クレジットカードの追加</h2>
    </div>
    <form class="payment-method__form" action="{{ route('payment_method.add.submit', ['item_id' => $item_id]) }}" method="POST">
        @csrf
        <div class="payment-method__row">
            <label class="payment-method__label" for="card_number">カード番号</label>
            <input class="payment-method__input form-control" type="text" name="card_number" id="card_number" value="">
        </div>
        <div class="payment-method__row">
            <label class="payment-method__label" for="cardholder_name">名義人</label>
            <input class="payment-method__input form-control" type="text" name="cardholder_name" id="cardholder_name" value="">
        </div>
        <div class="payment-method__row">
            <label class="payment-method__label" for="expiration_date">有効期限</label>
            <input class="payment-method__input form-control" type="text" name="expiration_date" id="expiration_date" value="">
        </div>
        <div class="payment-method__row">
            <button class="payment-method__button">追加する</button>
        </div>
    </form>
</div>
@endsection