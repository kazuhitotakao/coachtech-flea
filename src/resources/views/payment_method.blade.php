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
                <div class="payment-method__detail-radio" id="credit_details" style="display:none;">
                    <h3 class="payment-method__detail-title">クレジットカード詳細</h3>
                    @foreach ($payment_details_credit as $detail)
                        <div class="payment-method__detail-entry">
                            <input class="visually-hidden" id="{{ $detail->id }}" name="payment_detail_id" type="radio"
                                value="{{ $detail->id }}" onclick="updatePaymentDetailId(this.value);">
                            <label class="payment-method__detail-entry-label" for="{{ $detail->id }}">
                                <div class="payment-method__detail-wrapper">
                                    <table class="payment-method__detail-table">
                                        <tr class="payment-method__detail-row">
                                            <th class="payment-method__detail-label">カード番号</th>
                                            <td class="payment-method__detail-data">{{ $detail->formatted_card_number }}
                                            </td>
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
                            <form class="payment-method__delete-form"
                                action="{{ route('payment_method.delete', ['item_id' => $item_id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input name="payment_detail_id" type="hidden" value="{{ $detail->id }}">
                                <button class="payment-method__delete-button" type="submit">削除</button>
                            </form>
                        </div>
                    @endforeach
                    <form class="payment-method__add-form"
                        action="{{ route('payment_method.add.show', ['item_id' => $item_id]) }}" method="GET">
                        <button class="payment-method__add-button" type="submit">カードを追加する</button>
                    </form>
                </div>
            </div>
            <div class="payment-method__update col-md-5">
                <form class="payment-method__update-form"
                    action="{{ route('payment_method.update', ['item_id' => $item_id]) }}" method="POST">
                    @csrf
                    <input id="payment_method_id_input" name="payment_method_id" type="hidden" value="">
                    <input id="payment_detail_id_input" name="payment_detail_id" type="hidden" value="">
                    <button class="payment-method__update-button" type="submit">変更する</button>
                </form>
            </div>
        </div>

    @endsection
