@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_list.css') }}">
@endsection

@section('content')

<a href="/" class="recommended">おすすめ</a>
<a href="/my-list" class="my-list">マイリスト</a>
<hr>

<div class="wrapper grid">
    @foreach($items as $item)
    <div class="item__card">
        <div class="card__container">
            <a href="{{ route('items.user_detail', ['item_id' => $item->id]) }}">
                <img class="card__image-image" src="{{ $item->thumbnailUrl }}" alt="item_image">
            </a>
            <div class="card__favorite">
                @if(count($item->favorites) === 0)
                <form action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button class="item__like-btn"><i class="lar la-star like-btn"></i></button>
                </form>
                @else
                <form action="{{ route('unlike', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button class="item__like-btn"><i class="las la-star like-btn liked"></i></button>
                </form>
                @endif
            </div>
            <div class="card__price">
                ¥{{ number_format($item->sale_price) }}
            </div>
        </div>
        <div class="card__content">
            {{ $item->name }}
        </div>
    </div>
    @endforeach
</div>

@endsection