@extends('layouts.app')

@section('js')
<script src="{{ asset('js/image_gallery.js')}}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
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
                    @if(count($item->favorites) === 0)
                    <form class="item__favorite-form" action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button class="item__like-btn" data-favorites="{{ $favorites_count }}">
                            <i class="lar la-star like-btn"></i>
                        </button>
                    </form>
                    @else
                    <form class="item__favorite-form" action="{{ route('unlike', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button class="item__like-btn" data-favorites="{{ $favorites_count }}">
                            <i class="las la-star like-btn liked"></i>
                        </button>
                    </form>
                    @endif
                </div>
                <div class="item__comment">
                    <form class="item__comment-form" action="{{ route('comment.show', ['item_id' => $item->id]) }}" method="get">
                        <button class="item__comment-btn" data-comments="{{ $comments_count }}">
                            <i class="las la-comment comment-btn"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="comments-container">
                @foreach ($comments as $comment)
                <div class="comment__user-name {{ $comment->user_id === $item->user_id ? 'left' : 'right' }}">
                    <div>{{ $comment->user->name }}</div>
                </div>
                <div class=" comment__content {{ $comment->user_id === $item->user_id ? 'left' : 'right' }}">
                    <div>{{ $comment->comment }}</div>
                </div>
                @endforeach
            </div>
            <form class="comment-submit__form" action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="post">
                @csrf
                <h4 class="comment-submit__title">商品へのコメント</h4>
                <textarea name="comment" class="comment-submit__content"></textarea>
                <button class="comment-submit__button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection