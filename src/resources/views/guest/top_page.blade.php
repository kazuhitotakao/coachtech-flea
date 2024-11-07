@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/top_page.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a class="top-page__recommended" href="/guest">おすすめ</a>
    <a class="top-page__my-list" href="/guest/unauthorized_access">マイリスト</a>
    <hr>

    <div class="top-page__wrapper top-page__grid">
        @foreach ($items as $item)
            <div class="item-card">
                <div class="item-card__container">
                    @if ($item->isSold())
                        <a href="{{ route('item.guest_detail', ['item_id' => $item->id]) }}">
                            <img class="item-card__image" src="{{ $item->thumbnail_url }}" alt="item_image">
                        </a>
                        <div class="item-card__sold">
                            <p class="item-card__sold-text">SOLD</p>
                        </div>
                    @else
                        <a href="{{ route('item.guest_detail', ['item_id' => $item->id]) }}">
                            <img class="item-card__image" src="{{ $item->thumbnail_url }}" alt="item_image">
                        </a>
                    @endif
                    <div class="item-card__price">
                        ¥{{ number_format($item->sale_price) }}
                    </div>
                </div>
                <p class="item-card__name">
                    {{ $item->name }}
                </p>
            </div>
        @endforeach
    </div>
@endsection
