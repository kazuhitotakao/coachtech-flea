@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/top_page.css') }}">
@endsection

@section('content')

<a href="/guest" class="top-page__recommended">おすすめ</a>
<a href="/guest/unauthorized_access" class="top-page__my-list">マイリスト</a>
<hr>

<div class="top-page__wrapper top-page__grid">
    @foreach($items as $item)
    <div class="item-card">
        <div class="item-card__container">
            <a href="{{ route('items.guest_detail', ['item_id' => $item->id]) }}">
                <img class="item-card__image" src="{{ $item->thumbnailUrl }}" alt="item_image">
            </a>
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