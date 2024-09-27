@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')

商品詳細ページ </br>
{{ $item->name }}
{{ $brand_name }}
@foreach($categories_name as $category_name)
{{ $category_name }}
@endforeach

<form action="{{ route('purchase.show', ['item_id' => $item->id]) }}" method="get">
    <button>購入する</button>
</form>
@endsection