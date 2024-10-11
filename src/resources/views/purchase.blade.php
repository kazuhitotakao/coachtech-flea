@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="purchase__item-content col-lg-7 mt-5">
            <div class="purchase__item-wrapper">
                <div class="purchase__item-image-thumbnail">
                    <img src="{{ $imageUrl_thumbnail }}" alt="item_thumbnail">
                </div>
                <div class="purchase__item-info">
                    <h2 class="purchase__item-name">{{ $item->name }}</h2>
                    <p class="purchase__item-sale-price">¥{{ number_format($item->sale_price)}}</p>
                </div>
            </div>
            <div class="purchase__payment-method">
                <h3 class=" purchase__payment-method-title">支払い方法</h3>
                <a class="purchase__link" href="{{ route('payment_method.show', ['item_id' => $item->id]) }}">変更する</a>
            </div>
            <div class="purchase__payment-method-details">
                @if($payment_method_id == 1)
                <p class="purchase__payment-method-card-type">クレジットカード</p>
                <div class="purchase__payment-method-card">
                    <table class="purchase__payment-method-card-table">
                        <tr class="purchase__payment-method-card-row">
                            <th class="purchase__payment-method-card-label">カード番号</th>
                            <td class="purchase__payment-method-card-data">{{ $card_number }}</td>
                        </tr>
                        <tr class="purchase__payment-method-card-row">
                            <th class="purchase__payment-method-card-label">有効期限</th>
                            <td class="purchase__payment-method-card-data">{{ $expiration_date }}</td>
                        </tr>
                    </table>
                </div>
                @endif
                @if($payment_method_id == 2)
                <div class="purchase__payment-method-type">
                    <p class="purchase__payment-method-label">コンビニ払い</p>
                </div>
                @endif
                @if($payment_method_id == 3)
                <div class="purchase__payment-method-type">
                    <p class="purchase__payment-method-label">銀行振込</p>
                </div>
                @endif
                @if($payment_method_id == null)
                <div class="purchase__payment-method-type">
                    <p class="purchase__payment-method-label">※支払方法を設定してください</p>
                </div>
                @endif
            </div>


            <div class="purchase__address">
                <h3 class="purchase__address-title">配送先</h3>
                <a class="purchase__link" href="{{ route('purchase.edit.address', ['item_id' => $item->id]) }}">変更する</a>
            </div>
            @if(!empty($address))
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
            @endif
        </div>
        <div class="purchase__content col-lg-5 mt-5">
            <div class="purchase__summary">
                <table class="purchase__summary-table">
                    <tr class="purchase__summary-row">
                        <th class="purchase__summary-label-sale-price">商品代金</th>
                        <td class="purchase__summary-data-sale-price">
                            <span class="purchase__summary-value-sale-price">¥{{ number_format($item->sale_price)}}</span>
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
            <form class="purchase__form" action="{{ route('items.purchase', ['item_id' => $item->id]) }}" method="post">
                @csrf
                @if(!empty($address))
                <input type="hidden" name="address_id" value="{{ $address->id }}">
                @endif
                <input type="hidden" name="payment_method_id" value="{{ $payment_method_id }}">
                <input type="hidden" name="payment_detail_id" value="{{ $payment_detail_id }}">
                <input type="hidden" name="paid_price" value="{{ $paid_price }}">
                <button class="purchase__button">購入する</button>
            </form>
        </div>
    </div>
    @endsection