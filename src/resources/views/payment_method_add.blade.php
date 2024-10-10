@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment_method_add.css') }}">
@endsection

@section('content')

<div class="payment-method-add__content">
    <div class="payment-method-add__content-title">
        <h2>クレジットカードの追加</h2>
    </div>
    <form class="payment-method-add__form" action="{{ route('payment_method.add.submit', ['item_id' => $item_id]) }}" method="POST">
        @csrf
        <div class="payment-method-add__form-row">
            <label class="payment-method-add__form-label" for="card_number">カード番号</label>
            <input class="payment-method-add__form-input" type="text" name="card_number" id="card_number" value="">
        </div>
        <div class="payment-method-add__form-row">
            <label class="payment-method-add__form-label" for="cardholder_name">名義人</label>
            <input class="payment-method-add__form-input" type="text" name="cardholder_name" id="cardholder_name" value="">
        </div>
        <div class="payment-method-add__form-row">
            <label class="payment-method-add__form-label" for="expiration_date">有効期限</label>
            <input class="payment-method-add__form-input" type="text" name="expiration_date" id="expiration_date" value="">
        </div>
        <div class=" payment-method-add__form-row">
            <button class="payment-method-add__form-button">追加する</button>
        </div>
    </form>
</div>
@endsection