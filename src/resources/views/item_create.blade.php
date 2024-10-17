@extends('layouts.app')

@section('js')
<script src="{{ asset('js/item_image_upload.js')}}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_create.css') }}">
@endsection

@section('content')
<div class="item">
    <h1 class="item-title">商品の出品</h1>
    <h3 class="item-image__title">商品画像</h3>
    <!-- アップロードされた画像のプレビュー（セッションから取得して表示） -->
    @if (session()->has('uploaded_images_items'))
    <div class="item-image-thumbnail__wrapper">
        <div class="item-image-thumbnail">
            <img src="{{ asset('images/item_no-image.jpeg') }}" alt="item_thumbnail">
        </div>

        <h3 class="item-image-thumbnail-title">※ サムネイル画像を選択してください</h3>
        <div class="item-images">
            @foreach (session('uploaded_images_items') as $index => $image)
            <label for="{{ $index }}">
                <input type="radio" name="thumbnail_index" value="{{ $index }}" id="{{ $index }}" style="display: none;" onclick="updateThumbNailId(this.value);">
                <img class="item-images_image" src="{{ Storage::url($image) }}" alt="uploaded image">
            </label>
            @endforeach
        </div>
    </div>
    @endif
    <form action="{{ route('item.images.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="item-image__wrapper">
            <div class="item-image">
                <label class="item-image__file-upload-btn" for="images">画像を追加する</label>
                <input type="file" name="images[]" id="images" multiple style="display: none;">
                <p id="file_names">選択されたファイルはありません。</p>
                <div class="item-image__button">
                    <button type="submit" id="image_button" class="item-image__upload-btn">アプロード</button>
                </div>
                @if (session('upload_error'))
                <div class="alert alert-danger">{{ session('upload_error') }}</div>
                @endif
            </div>
        </div>
    </form>

    <form action="{{ route('item.store') }}" method="POST">
        @csrf
        <h2 class="item-detail__title">商品の詳細</h2>
        <hr>
        <div class="item-detail__wrapper">
            <div class="item-detail__category">
                <label for="categories">カテゴリー（複数選択可）</label>
                <select class="form-select mb-3" name="category_ids[]" id="categories" multiple>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="item-detail__condition">
                <label for="condition">商品の状態</label>
                <select class="form-select mb-3" name="condition_id" id="condition">
                    <option disabled selected>商品の状態を選択してください</option>
                    @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="item-detail__brand">
                <label for="brand">ブランド</label>
                <select class="form-select mb-3" name="brand_id" id="brand">
                    <option disabled selected>ブランドを選択してください</option>

                    @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <h2 class="item-overview__title">商品名と説明</h2>
        <hr>
        <div class="item-overview">
            <div>
                <label for="name">商品名</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>
            <div>
                <label for="description">商品の説明</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <h3 class="item-sale-price__title">販売価格</h3>
        <hr>
        <div class="item-sale-price">
            <label for="sale_price">販売価格</label>
            <input type="text" class="form-control" name="sale_price" id="sale_price">
        </div>
        <div>
            <input type="hidden" id="item_image_thumbnail_id" name="thumbnail_index" value="">
            <button class="item__button" type="submit">出品する</button>
        </div>
    </form>
</div>

@endsection