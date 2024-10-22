@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/item_image_upload.js') }}" defer></script>
    <script src="{{ asset('js/price.js') }}" defer></script>
@endsection

@section('css')
    <link href="{{ asset('css/item_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger custom-alert">
            <button class="btn-close float-end" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="item">
        <h1 class="item-title">商品の出品</h1>
        <h3 class="item-image__title">商品画像</h3>
        <!-- アップロードされた画像のプレビュー（セッションから取得して表示） -->
        @if (session()->has('uploaded_images_items'))
            <div class="item-image-thumbnail__wrapper">
                <div class="item-image-thumbnail">
                    @php
                        $selected_image =
                            old('thumbnail_index') !== null
                                ? Storage::url(session('uploaded_images_items')[old('thumbnail_index')])
                                : asset('images/item_no-image.jpeg');
                    @endphp
                    <img src="{{ $selected_image }}" alt="item_thumbnail">
                </div>
                <h3 class="item-image-thumbnail-title">※ サムネイル画像を選択してください</h3>
                <div class="item-images">
                    @foreach (session('uploaded_images_items') as $index => $image)
                        <label for="{{ $index }}">
                            <input id="{{ $index }}" name="thumbnail_index" type="radio"
                                value="{{ $index }}" style="display: none;" onclick="updateThumbNailId(this.value);"
                                {{ old('thumbnail_index') == $index ? 'checked' : '' }}>
                            <img class="item-images_image  {{ is_null(old('thumbnail_index')) ? 'default-class' : (old('thumbnail_index') == $index ? 'selected-image' : '') }}"
                                src="{{ Storage::url($image) }}" alt="uploaded image">
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
                    <input id="images" name="images[]" type="file" style="display: none;" multiple>
                    <p id="file_names">選択されたファイルはありません。</p>
                    <div class="item-image__button">
                        <button class="item-image__upload-btn" id="image_button" type="submit">アプロード</button>
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
                    <select class="form-select mb-3" id="categories" name="category_ids[]" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="item-detail__condition">
                    <label for="condition">商品の状態</label>
                    <select class="form-select mb-3" id="condition" name="condition_id">
                        <option disabled selected>商品の状態を選択してください</option>
                        @foreach ($conditions as $condition)
                            <option value="{{ $condition->id }}"
                                {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="item-detail__brand">
                    <label for="brand">ブランド（任意）</label>
                    <select class="form-select mb-3" id="brand" name="brand_id">
                        <option disabled selected>ブランドを選択してください</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <h2 class="item-overview__title">商品名と説明</h2>
            <hr>
            <div class="item-overview">
                <div>
                    <label for="name">商品名</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="description">商品の説明（任意）</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                </div>
                <h3 class="item-sale-price__title">販売価格</h3>
                <hr>
                <div class="item-sale-price">
                    <label for="sale_price">販売価格</label>
                    <div class="input-container">
                        <span class="currency-symbol">¥</span>
                        <input class="form-control item-sale-price__input" id="sale_price" name="sale_price" type="tel"
                            value="{{ old('sale_price') }}">
                    </div>
                </div>
                <div>
                    <input id="item_image_thumbnail_id" name="thumbnail_index" type="hidden"
                        value=" {{ old('thumbnail_index') }}">
                    <button class="item__button" type="submit">出品する</button>
                </div>
        </form>
    </div>
@endsection
