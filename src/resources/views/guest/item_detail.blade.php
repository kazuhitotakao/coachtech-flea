@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')

<p>商品詳細ページ</p>
<p>{{ $item->name }}</p>
<a href="{{ route('comment.show', ['item_id' => $item->id]) }}">コメント</a>
<p>{{ $brand_name }}</p>
@foreach($categories_name as $category_name)
<p>{{ $category_name }}</p>
@endforeach

<form action="{{ route('purchase.show', ['item_id' => $item->id]) }}" method="get">
    <button>購入する</button>
</form>
@endsection