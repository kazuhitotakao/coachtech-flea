@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/top_page.css') }}">
@endsection

@section('content')

@php $count = 0; @endphp
@foreach($items as $item)
<a href="{{ route('items.user_detail', ['item_id' => $item->id]) }}">
    <img src="{{ $imagesUrl[$count] }}" alt="item_image" width="200px" height="200px">
</a>
@if(count($item->favorites) === 0)
<form action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
    @csrf
    <button class="item__like-btn"><i class="lar la-heart like-btn"></i></button>
</form>
@else
<form action="{{ route('unlike', ['item_id' => $item->id]) }}" method="POST">
    @csrf
    <button class="item__like-btn"><i class="las la-heart like-btn liked"></i></button>
</form>
@endif
@php $count++ ; @endphp
@endforeach

@endsection