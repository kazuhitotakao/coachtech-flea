@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')

<h2>商品の出品</h2>

<form action="/sell" method="POST">
    @csrf
    <button>出品する</button>
</form>
@endsection