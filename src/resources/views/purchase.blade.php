@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')


<p>購入ページ</p>
<p>支払い方法</p>
<p>配送先</p>
<a href="{{ route('purchase.edit.address', ['item_id' => $item->id]) }}">変更する</a>


<form action="{{ route('items.purchase', ['item_id' => $item->id]) }}" method="post">
    @csrf
    <button>購入する</button>
</form>

@endsection