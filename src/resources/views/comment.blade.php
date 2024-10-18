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
                <img src="{{ $image_url_thumbnail }}" alt="item_thumbnail">
            </div>
            <div class="item__images">
                @foreach( $image_urls as $image_url )
                <img src="{{ $image_url }}" alt="item_image">
                @endforeach
            </div>
        </div>
        <div class="item__detail col-md-6 mt-5">
            <h2 class="item__name">{{ $item->name }}</h2>
            <span class="item__brand-name">{{ $brand_name }}</span>
            <p class="item__sale-price">¥{{ number_format($item->sale_price)}}</p>
            <div class="icon__wrapper">
                <div class="icon__favorite">
                    @if(count($item->favorites) === 0)
                    <form class="icon__favorite-form" action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button class="icon__like-btn" data-favorites="{{ $favorites_count }}">
                            <i class="lar la-star like-btn"></i>
                        </button>
                    </form>
                    @else
                    <form class="icon__favorite-form" action="{{ route('unlike', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button class="icon__like-btn" data-favorites="{{ $favorites_count }}">
                            <i class="las la-star like-btn liked"></i>
                        </button>
                    </form>
                    @endif
                </div>
                <div class="icon__comment">
                    <form class="icon__comment-form" action="{{ route('comment.show', ['item_id' => $item->id]) }}" method="GET">
                        <button class="icon__comment-btn" data-comments="{{ $comments_count }}">
                            <i class="las la-comment comment-btn"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="comment__list">
                @foreach ($comments as $comment)
                @if($comment->user_id === $item->user_id)
                <div class="comment__user-name left">
                    <div class="comment__user-icon-background">
                        <div class="comment__user-icon">
                            <img src="{{ $comment->user_url_thumbnail ? $comment->user_url_thumbnail : asset('images/user_no-name.jpeg')}}" alt="user_thumbnail">
                        </div>
                    </div>
                    <span>{{ $comment->user->name }}</span>
                </div>
                <div class="comment__content left">
                    <p>{{ $comment->comment }}</p>
                </div>
                @else
                <div class="comment__user-name right">
                    <span>{{ $comment->user->name }}</span>
                    <div class="comment__user-icon-background">
                        <div class="comment__user-icon">
                            <img src="{{ $comment->user_url_thumbnail ? $comment->user_url_thumbnail : asset('images/user_no-name.jpeg')}}" alt="user_thumbnail">
                        </div>
                    </div>
                </div>
                <div class="comment__content right">
                    <p>{{ $comment->comment }}</p>
                </div>
                @endif
                @endforeach
            </div>
            <form class="comment__form" action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="POST">
                @csrf
                <h4 class="comment__form-title">商品へのコメント</h4>
                <textarea name="comment" class="comment__form-content form-control"></textarea>
                <button class="comment__form-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection