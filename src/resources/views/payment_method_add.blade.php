@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment_method_add.css') }}">
@endsection

@section('content')

<div class="payment-method-add__content">
    <div class="payment-method-add__content-title">
        <h2>住所の変更</h2>
    </div>
    <form class="payment-method-add__form" action="" method="post">
        @csrf
        <div class="payment-method-add__form-row">
            <label class="payment-method-add__form-label" for="postcode">郵便番号</label>
            <input class="payment-method-add__form-input" type="text" name="postcode" id="postcode" value="{{}}">
        </div>
        <div class="payment-method-add__form-row">
            <label class="payment-method-add__form-label" for="address">住所</label>
            <input class="payment-method-add__form-input" type="text" name="address" id="address" value="{{}}">
        </div>
        <div class="payment-method-add__form-row">
            <label class="payment-method-add__form-label" for="building">建物名</label>
            <input class="payment-method-add__form-input" type="text" name="building" id="building" value=" {{}}">
        </div>
        <div class=" payment-method-add__form-row">
            <button class="payment-method-add__form-button">追加する</button>
        </div>
    </form>
</div>
@endsection