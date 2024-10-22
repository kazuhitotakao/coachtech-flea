@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/my_list.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a class="top-page__recommended" href="/">おすすめ</a>
    <a class="top-page__my-list" href="/my-list">マイリスト</a>
    <hr>

    <div class="top-page__wrapper top-page__grid">
        @foreach ($items as $item)
            <div class="item-card">
                <div class="item-card__container">
                    @if ($item->isSold())
                        <a href="{{ route('item.user_detail', ['item_id' => $item->id]) }}">
                            <img class="item-card__image" src="{{ $item->thumbnail_url }}" alt="item_image">
                        </a>
                        <div class="item-card__sold">
                            <p class="item-card__sold-text">SOLD</p>
                        </div>
                    @else
                        <a href="{{ route('item.user_detail', ['item_id' => $item->id]) }}">
                            <img class="item-card__image" src="{{ $item->thumbnail_url }}" alt="item_image">
                        </a>
                    @endif
                    <div class="item-card__favorite">
                        @if (count($item->favorites) === 0)
                            <form action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
                                @csrf
                                <button class="item-card__like-btn"><i class="lar la-star like-btn"></i></button>
                            </form>
                        @else
                            <form action="{{ route('unlike', ['item_id' => $item->id]) }}" method="POST">
                                @csrf
                                <button class="item-card__like-btn"><i class="las la-star like-btn liked"></i></button>
                            </form>
                        @endif
                    </div>
                    <div class="item-card__price">
                        ¥{{ number_format($item->sale_price) }}
                    </div>
                </div>
                <div class="item-card__name">
                    {{ $item->name }}
                </div>
            </div>
        @endforeach
    </div>
@endsection
