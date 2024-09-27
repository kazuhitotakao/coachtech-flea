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
@php $count++ ; @endphp
@endforeach

@endsection