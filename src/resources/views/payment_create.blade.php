@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/payment_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        @if (session('flash_alert'))
            <div class="alert alert-danger">{{ session('flash_alert') }}</div>
        @endif
        <div class="d-flex p-5 justify-content-center">
            <div class="col-6 card">
                <div class="card-header">Stripe決済</div>
                <div class="card-body">
                    <form id="card_form" action="{{route('payment.store', ['item_id' => $item_id])}}" method="POST">
                        @csrf
                        <div>
                            <label for="card_number">カード番号</label>
                            <div class="form-control" id="card_number"></div>
                        </div>
                        <div>
                            <label for="card_expiry">有効期限</label>
                            <div class="form-control" id="card_expiry"></div>
                        </div>
                        <div>
                            <label for="card_cvc">セキュリティコード</label>
                            <div class="form-control" id="card_cvc"></div>
                        </div>
                        <div class="text-danger" id="card_errors"></div>
                        <input name="paid_price" type="hidden" value="{{ $paid_price }}">
                        <input name="payment_detail_id" type="hidden" value="{{ $payment_detail_id }}">
                        <button class="mt-3 custom-button">支払い</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('parts.payment')
@endsection
