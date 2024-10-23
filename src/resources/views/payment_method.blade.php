@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/payment_method.js') }}" defer></script>
@endsection

@section('css')
    <link href="{{ asset('css/payment_method.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger custom-alert">
            <button class="btn-close float-end" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="payment-method col-md-7">
                @csrf
                <h3 class="payment-method__title">支払い方法</h3>
                <div class="payment-method__radio">
                    <input class="visually-hidden" id="credit" name="payment_method_id" type="radio" value="1"
                        onchange="handlePaymentMethodChange(this.value);">
                    <label class="payment-method__radio-label" for="credit">クレジットカード</label>
                    <input class="visually-hidden" id="convenience" name="payment_method_id" type="radio" value="2"
                        onchange="handlePaymentMethodChange(this.value);">
                    <label class="payment-method__radio-label" for="convenience">コンビニ</label>
                    <input class="visually-hidden" id="bank" name="payment_method_id" type="radio" value="3"
                        onchange="handlePaymentMethodChange(this.value);">
                    <label class="payment-method__radio-label" for="bank">銀行振込</label>
                </div>
            </div>
            <div class="payment-method__update col-md-5">
                <form class="payment-method__update-form"
                    action="{{ route('payment_method.update', ['item_id' => $item_id]) }}" method="POST">
                    @csrf
                    <input id="payment_method_id_input" name="payment_method_id" type="hidden" value="">
                    <button class="payment-method__update-button" type="submit">変更する</button>
                </form>
            </div>
        </div>

    @endsection
