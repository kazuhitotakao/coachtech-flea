@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/purchase.css') }}" rel="stylesheet">
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
        <a class="item__back-button" href="{{ route('item.user_detail', ['item_id' => $item->id]) }}">&lt</a>
        <div class="row">
            <div class="purchase__item-content col-lg-7 mt-5">
                <div class="purchase__item-wrapper">
                    <div class="purchase__item-image-thumbnail">
                        <img src="{{ $image_url_thumbnail }}" alt="item_thumbnail">
                    </div>
                    <div class="purchase__item-info">
                        <h2 class="purchase__item-name">{{ $item->name }}</h2>
                        <p class="purchase__item-sale-price">¥{{ number_format($item->sale_price) }}</p>
                    </div>
                </div>
                <div class="purchase__payment-method">
                    <h3 class="purchase__payment-method-title">支払い方法</h3>
                    <a class="purchase__link" href="{{ route('payment_method.show', ['item_id' => $item->id]) }}">変更する</a>
                </div>
                <div class="purchase__payment-method-details">
                    @if ($payment_method_id == 1)
                        <div class="purchase__payment-method-type">
                            <p class="purchase__payment-method-label">クレジットカード</p>
                        </div>
                    @endif
                    @if ($payment_method_id == 2)
                        <div class="purchase__payment-method-type">
                            <p class="purchase__payment-method-label">コンビニ払い</p>
                        </div>
                    @endif
                    @if ($payment_method_id == 3)
                        <div class="purchase__payment-method-type">
                            <p class="purchase__payment-method-label">銀行振込</p>
                        </div>
                    @endif
                    @if ($payment_method_id == null)
                        <div class="purchase__payment-method-type">
                            <p class="purchase__payment-method-label">※支払い方法を設定してください</p>
                        </div>
                    @endif
                </div>

                <div class="purchase__address">
                    <h3 class="purchase__address-title">配送先</h3>
                    <a class="purchase__link" href="{{ route('purchase.edit.address', ['item_id' => $item->id]) }}">変更する</a>
                </div>
                @if (!empty($address))
                    <div class="purchase__address-wrapper">
                        <table class="purchase__address-table">
                            <tr class="purchase__address-row">
                                <th class="purchase__address-label">郵便番号</th>
                                <td class="purchase__address-data">{{ $address->getFormattedPostalCode() }}</td>
                            </tr>
                            <tr class="purchase__address-row">
                                <th class="purchase__address-label">配送先住所</th>
                                <td class="purchase__address-data">{{ $address->address }}</td>
                            </tr>
                            <tr class="purchase__address-row">
                                <th class="purchase__address-label">建物名</th>
                                <td class="purchase__address-data">{{ $address->building }}</td>
                            </tr>
                        </table>
                    </div>
                @else
                    <div class="purchase__address-wrapper purchase__address-wrapper--alert">
                        <p class="purchase__address-label purchase__address-label--alert">※配送先を設定してください</p>
                    </div>
                @endif
            </div>
            <div class="purchase__content col-lg-5 mt-5">
                <div class="purchase__summary">
                    <table class="purchase__summary-table">
                        <tr class="purchase__summary-row">
                            <th class="purchase__summary-label-sale-price">商品代金</th>
                            <td class="purchase__summary-data-sale-price">
                                <span
                                    class="purchase__summary-value-sale-price">¥{{ number_format($item->sale_price) }}</span>
                            </td>
                        </tr>
                        <tr class="purchase__summary-row">
                            <th class="purchase__summary-label">支払い金額</th>
                            <td class="purchase__summary-data">
                                <span class="purchase__summary-value-paid-price">¥{{ $paid_price_format }}</span>
                            </td>
                        </tr>
                        <tr class="purchase__summary-row">
                            <th class="purchase__summary-label">支払い方法</th>
                            <td class="purchase__summary-data">
                                <span class="purchase__summary-value-payment-method">{{ $payment_method_name }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <form class="purchase__form"
                    action="{{ $payment_method_id == 1 ? route('payment.create', ['item_id' => $item->id]) : route('items.purchase', ['item_id' => $item->id]) }}"
                    method="{{ $payment_method_id == 1 ? 'GET' : 'POST' }}">
                    @if ($payment_method_id != 1)
                        @csrf
                    @endif
                    <input name="address_id" type="hidden" value="{{ $address_id }}">
                    <input name="payment_method_id" type="hidden" value="{{ $payment_method_id }}">
                    <input name="payment_detail_id" type="hidden" value="{{ $payment_detail_id }}">
                    <input name="paid_price" type="hidden" value="{{ $paid_price }}">
                    <button class="purchase__button">購入する</button>
                </form>
            </div>
        </div>
    @endsection
