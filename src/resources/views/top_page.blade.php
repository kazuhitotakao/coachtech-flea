@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/top_page.css') }}">
@endsection

@section('content')

<a href="/" class="top-page__recommended">おすすめ</a>
<a href="/my-list" class="top-page__my-list">マイリスト</a>
<hr>

<div class="top-page__wrapper top-page__grid">
    @foreach($items as $item)
    <div class="item-card">
        <div class="item-card__container">
            <a href="{{ route('items.user_detail', ['item_id' => $item->id]) }}">
                <img class="item-card__image" src="{{ $item->thumbnailUrl }}" alt="item_image">
            </a>
            <div class="item-card__favorite">
                @if(count($item->favorites) === 0)
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