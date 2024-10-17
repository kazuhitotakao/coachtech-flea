@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page_purchased.css') }}">
@endsection

@section('content')
<div class="my-page__profile">
    <div class="my-page__user-icon-background">
        <div class="my-page__user-icon">
            <img src="{{ $user->user_image_id ? $user->thumbnail_url : asset('images/user_no-name.jpeg') }}" alt="item_thumbnail">
        </div>
    </div>
    <h1 class="my-page__user-name">{{ $user->name ?: '名前未設定' }}</h1>
    <div class="my-page__profile-link-wrapper">
        <a href="/my-page/profile" class="my-page__profile-link">プロフィールを編集</a>
    </div>
</div>

<a href="/my-page/listed" class="my-page__listed-items">出品した商品</a>
<a href="/my-page/purchased" class="my-page__purchased-items">購入した商品</a>
<hr>

<div class="my-page__wrapper my-page__grid">
    @foreach($items as $item)
    <div class="item-card">
        <div class="item-card__container">
            <a href="{{ route('item.user_detail', ['item_id' => $item->id]) }}">
                <img class="item-card__image" src="{{ $item->thumbnail_url }}" alt="item_image">
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