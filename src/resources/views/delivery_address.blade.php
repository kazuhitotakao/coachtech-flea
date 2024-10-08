@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/delivery_address.css') }}">
@endsection

@section('content')

<div class="delivery__content">
    <div class="delivery__content-title">
        <h2>配送先の変更</h2>
    </div>
    <form class="delivery__form" action="{{ route('purchase.update.address', ['item_id' => $item->id]) }}" method="post">
        @csrf
        <div class="delivery__form-row">
            <label class="delivery__form-label" for="postcode">郵便番号</label>
            <input class="delivery__form-input" type="text" name="postcode" id="postcode">
        </div>
        <div class="delivery__form-row">
            <label class="delivery__form-label" for="address">配送先住所</label>
            <input class="delivery__form-input" type="text" name="address" id="address">
        </div>
        <div class="delivery__form-row">
            <label class="delivery__form-label" for="building">建物名</label>
            <input class="delivery__form-input" type="text" name="building" id="building">
        </div>
        <div class="delivery__form-row">
            <button class="delivery__form-button">更新する</button>
        </div>
    </form>
</div>
@endsection