@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/card_number.js') }}" defer></script>
@endsection

@section('css')
    <link href="{{ asset('css/payment_method_add.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="payment-method">
        <div class="payment-method__title">
            <h2>クレジットカードの追加</h2>
        </div>
        <form class="payment-method__form" action="{{ route('payment_method.add.submit', ['item_id' => $item_id]) }}"
            method="POST">
            @csrf
            <div class="payment-method__row">
                <label class="payment-method__label" for="card_number">カード番号</label>
                <input class="payment-method__input form-control" id="card_number" name="card_number" type="tel"
                    value="{{ old('card_number') }}" placeholder="1234 1234 1234 1234">
                @error('card_number')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
            </div>
            <div class="payment-method__row">
                <label class="payment-method__label" for="cardholder_name">カード名義<span
                        class="break-point">（アルファベット大文字）</span></label>
                <input class="payment-method__input form-control" id="cardholder_name" name="cardholder_name" type="text"
                    value="{{ old('cardholder_name') }}" style="text-transform: uppercase;" placeholder="例: TARO YAMADA">
                @error('cardholder_name')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
            </div>
            <div class="payment-method__row">
                <label class="payment-method__label" for="expiration_date">有効期限</label>
                <div class="payment-method__input-wrapper">
                    <select class="form-control" id="expiration_month" name="expiration_month">
                        <option disabled selected>月</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ sprintf('%02d', $month) }}"
                                {{ old('expiration_month') == sprintf('%02d', $month) ? 'selected' : '' }}>
                                {{ sprintf('%02d', $month) }}
                            </option>
                        @endforeach
                    </select>
                    <select class="form-control" id="expiration_year" name="expiration_year">
                        <option disabled selected>年</option>
                        @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                            <option value="{{ $i }}" {{ old('expiration_year') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                @error('expiration_month')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
                @error('expiration_year')
                    <div class="form__error">
                        ※{{ $message }}
                    </div>
                @enderror
            </div>
            <div class="payment-method__row">
                <button class="payment-method__button">追加する</button>
            </div>
        </form>
    </div>
@endsection
