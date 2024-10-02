@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endsection

@section('content')

<pre>コメントページ </pre>
{{ $item->name }}
{{ $brand_name }}

<form action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="post">
    @csrf
    <button>コメントを送信する</button>
</form>
@endsection