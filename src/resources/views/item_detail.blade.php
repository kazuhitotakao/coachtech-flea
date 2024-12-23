@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/image_gallery.js') }}" defer></script>
@endsection

@section('css')
    <link href="{{ asset('css/item_detail.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <a class="item__back-button" href="/">&lt</a>
        <div class="row">
            <div class="item__image col-md-6 mt-5">
                <div class="item__image-thumbnail">
                    <img src="{{ $image_url_thumbnail }}" alt="item_thumbnail">
                </div>
                <div class="item__images">
                    @foreach ($image_urls as $image_url)
                        <img src="{{ $image_url }}" alt="item_image">
                    @endforeach
                </div>
            </div>
            <div class="item__detail col-md-6 mt-5">
                <h2 class="item__name">{{ $item->name }}</h2>
                <span class="item__brand-name">{{ $brand_name }}</span>
                <p class="item__sale-price">¥{{ number_format($item->sale_price) }}</p>
                <div class="icon__wrapper">
                    <div class="icon__favorite">
                        @if (count($item->favorites) === 0)
                            <form class="icon__favorite-form" action="{{ route('like', ['item_id' => $item->id]) }}"
                                method="POST">
                                @csrf
                                <button class="icon__like-btn" data-favorites="{{ $favorites_count }}">
                                    <i class="lar la-star like-btn"></i>
                                </button>
                            </form>
                        @else
                            <form class="icon__favorite-form" action="{{ route('unlike', ['item_id' => $item->id]) }}"
                                method="POST">
                                @csrf
                                <button class="icon__like-btn" data-favorites="{{ $favorites_count }}">
                                    <i class="las la-star like-btn liked"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="icon__comment">
                        <form class="icon__comment-form" action="{{ route('comment.show', ['item_id' => $item->id]) }}"
                            method="GET">
                            <button class="icon__comment-btn" data-comments="{{ $comments_count }}">
                                <i class="las la-comment comment-btn"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <form class="item__purchase-form" action="{{ route('purchase.show', ['item_id' => $item->id]) }}"
                    method="GET">
                    <button class="item__purchase-button"
                        style="display: {{ $item->isSold() ? 'none' : 'inline-block' }}">購入する</button>
                </form>
                <h4 class="item__description">商品説明</h4>
                <p class="item__description-content">{{ $item->description }}</p>
                <h4 class="item__table-title">商品の情報</h4>
                <table class="item__table">
                    <tr class="item__row">
                        <th class="item__label">カテゴリー</th>
                        <td class="item__data">
                            @foreach ($categories_name as $category_name)
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
