@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/address.css') }}" rel="stylesheet">
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
                <label class="address__form-label" for="postcode">郵便番号（数字7桁)
                </label>
                <input class="address__form-input form-control" id="postcode" name="postcode" type="number"
                    value="{{ old('postcode', $address->postcode) }}">
                @error('postcode')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
            </div>
            <div class="address__form-group">
                <label class="address__form-label" for="address">住所</label>
                <input class="address__form-input form-control" id="address" name="address" type="text"
                    value="{{ old('address', $address->address) }}">
                @error('address')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
            </div>
            <div class="address__form-group">
                <label class="address__form-label" for="building">建物名</label>
                <input class="address__form-input form-control" id="building" name="building" type="text"
                    value="{{ old('building', $address->building) }}">
                @error('building')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
            </div>
            <div class="address__form-group">
                <button class="address__form-button">更新する</button>
            </div>
        </form>
    </div>
@endsection
