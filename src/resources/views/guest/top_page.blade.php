@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/top_page.css') }}">
@endsection

@section('content')

<a href="/guest" class="recommended">おすすめ</a>
<a href="/guest/unauthorized_access" class="my-list">マイリスト</a>
<hr>

<div class="wrapper grid">
    @foreach($items as $item)
    <div class="item__card">
        <div class="card__container">
            <a href="{{ route('items.guest_detail', ['item_id' => $item->id]) }}">
                <img class="card__image-image" src="{{ $item->thumbnailUrl }}" alt="item_image">
            </a>
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