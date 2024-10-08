@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="item__content col-md-7 mt-5">
            <div class="item__purchase-wrapper">
                <div class="item__image-thumbnail">
                    <img src="{{ $imageUrl_thumbnail }}" alt="item_thumbnail">
                </div>
                <div class="item__info">
                    <h2 class="item__name">{{ $item->name }}</h2>
                    <p class="item__sale-price">¥{{ number_format($item->sale_price)}}</p>
                </div>
            </div>
            <div class="item__payment-method">
                <h3 class=" item__payment-method-title">支払い方法</h3>
                <a class="purchase__link" href="#">変更する</a>

            </div>
            <div class="item__delivery-address">
                <h3 class="item__delivery-address-title">配送先</h3>
                <a class="purchase__link" href="{{ route('purchase.edit.address', ['item_id' => $item->id]) }}">変更する</a>
            </div>
            @if(!empty($show_delivery_address))
            <div class="item__delivery-address-wrapper">
                <table class="item__delivery-address-table">
                    <tr class="item__delivery-address-row">
                        <th class="item__delivery-address-label">郵便番号</th>
                        <td class="item__delivery-address-data">{{ $show_delivery_address->getFormattedPostalCode() }}</td>
                    </tr>
                    <tr class="item__delivery-address-row">
                        <th class="item__delivery-address-label">配送先住所</th>
                        <td class="item__delivery-address-data">{{ $show_delivery_address->address }}</td>
                    </tr>
                    <tr class="item__delivery-address-row">
                        <th class="item__delivery-address-label">建物名</th>
                        <td class="item__delivery-address-data">{{ $show_delivery_address->building }}</td>
                    </tr>
                </table>
            </div>
            @endif

        </div>
        <div class="purchase__content col-md-5 mt-5">
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
                            <span class="purchase__summary-value-paid-price">¥99,999</span>
                        </td>
                    </tr>
                    <tr class="purchase__summary-row">
                        <th class="purchase__summary-label">支払い方法</th>
                        <td class="purchase__summary-data">
                            <span class="purchase__summary-value-payment-method">クレジットカード</span>
                        </td>
                    </tr>
                </table>

            </div>
            <form class="purchase__form" action="{{ route('items.purchase', ['item_id' => $item->id]) }}" method="post">
                @csrf
                @if(!empty($show_delivery_address))
                <input type="hidden" name="postcode" value="{{ $show_delivery_address->postcode }}">
                <input type="hidden" name="address" value="{{ $show_delivery_address->address }}">
                <input type="hidden" name="building" value="{{ $show_delivery_address->building }}">
                @endif
                <button class="purchase__button">購入する</button>
            </form>
        </div>
    </div>
    @endsection