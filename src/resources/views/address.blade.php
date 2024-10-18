@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<div class="address">
    <div class="address__title">
        <h2>住所の変更</h2>
    </div>
    <form class="address__form" action="{{ route('purchase.update.address', ['item_id' => $item->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="address__form-group">
            <label class="address__form-label" for="postcode">郵便番号</label>
            <input class="address__form-input form-control" type="text" name="postcode" id="postcode" value="{{ $address->postcode ?? '' }}">
        </div>
        <div class="address__form-group">
            <label class="address__form-label" for="address">住所</label>
            <input class="address__form-input form-control" type="text" name="address" id="address" value="{{ $address->address ?? '' }}">
        </div>
        <div class="address__form-group">
            <label class="address__form-label" for="building">建物名</label>
            <input class="address__form-input form-control" type="text" name="building" id="building" value="{{ $address->building ?? '' }}">
        </div>
        <div class="address__form-group">
            <button class="address__form-button">更新する</button>
        </div>
    </form>
</div>
@endsection