@extends('layouts.app')

@section('js')
<script src="{{ asset('js/image_gallery.js')}}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="item__image col-md-6 mt-5">
            <div class="item__image-thumbnail">
                <img src="{{ $imageUrl_thumbnail }}" alt="item_thumbnail">
            </div>
            <div class="item__images">
                @foreach( $imagesUrl as $imageUrl )
                <img src="{{ $imageUrl }}" alt="item_image">
                @endforeach
            </div>
        </div>
        <div class="item__detail col-md-6 mt-5">
            <h2 class="item__name">{{ $item->name }}</h2>
            <span class="item__brand-name">{{ $brand_name }}</span>
            <p class="item__sale-price">¥{{ number_format($item->sale_price)}}</p>
            <div class="icon__wrapper">
                <div class="item__favorite">
                    <form class="item__favorite-form" action="/guest/unauthorized_access" method="get">
                        @csrf
                        <button class="item__like-btn" data-favorites="{{ $favorites_count }}">
                            <i class="lar la-star like-btn"></i>
                        </button>
                    </form>
                </div>
                <div class="item__comment">
                    <form class="item__comment-form" action="/guest/unauthorized_access" method="get">
                        <button class="item__comment-btn" data-comments="test">
                            <i class="las la-comment comment-btn"></i>
                        </button>
                    </form>
                </div>
            </div>
            <form class="purchase__form" action="/guest/unauthorized_access" method="get">
                <button class="purchase__button">購入する</button>
            </form>
            <h4 class="item__description">商品説明</h4>
            <p class="item__description-content">{{$item->description}}</p>
            <h4 class="table__title">商品の情報</h4>
            <table class="item__table">
                <tr class="item__row">
                    <th class="item__label">カテゴリー</th>
                    <td class="item__data">
                        @foreach($categories_name as $category_name)
                        <span class="item__data-category">{{ $category_name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr class="item__row">
                    <th class="item__label">商品の状態</th>
                    <td class="item__data">
                        <span class="item__data-condition">{{ $item->condition->name }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection