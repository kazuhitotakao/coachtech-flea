@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
@endsection

@section('content')

<form action="/my-page/profile" method="get">
    <button>プロフィールを編集</button>
</form>

@php $count = 0; @endphp
@foreach($items as $item)
<a href="{{ route('items.user_detail', ['item_id' => $item->id]) }}">
    <img src="{{ $imagesUrl[$count] }}" alt="item_image" width="200px" height="200px">
</a>
@php $count++ ; @endphp
@endforeach

@endsection