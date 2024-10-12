@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_create.css') }}">
@endsection

@section('content')

<h2>商品の出品</h2>

<form action="{{ route('item.images.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" id="images" multiple>
    <label for="images">画像をアップロード：</label>
    <button type="submit">画像をアップロード</button>
</form>

<form action="{{ route('item.store') }}" method="POST">
    @csrf
    <!-- アップロードされた画像のプレビュー（セッションから取得して表示） -->
    @if (session()->has('uploaded_images'))
    <div>
        <h3>アップロードされた画像：</h3>
        @foreach (session('uploaded_images') as $index => $image)
        <div>
            <img src="{{ Storage::url($image) }}" alt="uploaded image" style="width: 150px;">
            <input type="radio" name="thumbnail_index" value="{{ $index }}" id="{{ $index }}">
            <label for="{{ $index }}">この画像をサムネイルにする</label>
        </div>
        @endforeach
    </div>
    @endif
    <h3>商品名</h3>
    <input type="text" name="name" value="{{ old('name') }}">
    <button type="submit">出品する</button>
</form>
@endsection