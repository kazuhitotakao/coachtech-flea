@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

購入ページ<br>
支払い方法<br>
配送先<br>

<form action="{{ route('items.purchase', ['item_id' => $item->id]) }}" method="post">
    @csrf
    <button>購入する</button>
</form>

@endsection