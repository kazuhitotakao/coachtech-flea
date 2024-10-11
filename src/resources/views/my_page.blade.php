@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
@endsection

@section('content')

<form action="/my-page/profile" method="GET">
    <button>プロフィールを編集</button>
</form>

@foreach($items as $item)
<a href="{{ route('items.user_detail', ['item_id' => $item->id]) }}">
    <img src="{{ $item->thumbnailUrl }}" alt="item_image" width="200px" height="200px">
</a>
@endforeach

@endsection