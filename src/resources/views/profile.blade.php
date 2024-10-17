@extends('layouts.app')

@section('js')
<script src="{{ asset('js/user_image_upload.js')}}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile__title">
    <h2>プロフィール設定</h2>
</div>

<!-- アップロードされた画像のプレビュー -->
<div class="profile-image">
    @if (!empty($image_urls))
    <div class="profile-image-thumbnail__wrapper">
        <div class="profile-image-thumbnail">
            @if(empty($image_url_thumbnail))
            <img src="{{ asset('images/user_no-name.jpeg') }}" alt="user_thumbnail">
            @else
            <img src="{{ $image_url_thumbnail }}" alt="user_thumbnail">
            @endif
        </div>

        <h3 class="profile-image-thumbnail-title">※ サムネイル画像を選択してください</h3>
        <div class="profile-images">
            @foreach ( $image_urls as $image_url )
            <label for="{{ $image_url['id'] }}">
                <input type="radio" name="thumbnail_id" value="{{ $image_url['id'] }}" id="{{ $image_url['id'] }}" style="display: none;" onclick="updateThumbNailId(this.value);">
                <img class="profile-images_image" src="{{ $image_url['url'] }}" alt="uploaded image">
            </label>
            @endforeach
        </div>
    </div>
    @endif
    <form action="{{ route('user.images.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="profile-image__wrapper">
            <div class="profile-image">
                <label class="profile-image__file-upload-btn" for="images">画像を追加する</label>
                <input type="file" name="images[]" id="images" multiple style="display: none;">
                <p id="file_names">選択されたファイルはありません。</p>
                <div class="profile-image__button">
                    <button type="submit" id="image_button" class="profile-image__upload-btn">アプロード</button>
                </div>
                @if (session('upload_error'))
                <div class="alert alert-danger">{{ session('upload_error') }}</div>
                @endif
            </div>
        </div>
    </form>
</div>

<div class="profile">
    <form class="profile__form" action="/my-page/profile" method="post">
        @csrf
        @method('PUT')
        <div class="profile__form-group">
            <label class="profile__form-label" for="user_name">ユーザー名</label>
            <input class="profile__form-input" type="text" name="user_name" id="user_name" value="{{ $user->name ?? '' }}">
        </div>
        <div class="profile__form-group">
            <label class="profile__form-label" for="postcode">郵便番号</label>
            <input class="profile__form-input" type="text" name="postcode" id="postcode" value="{{ $address->postcode ?? '' }}">
        </div>
        <div class="profile__form-group">
            <label class="profile__form-label" for="address">住所</label>
            <input class="profile__form-input" type="text" name="address" id="address" value="{{ $address->address ?? '' }}">
        </div>
        <div class="profile__form-group">
            <label class="profile__form-label" for="building">建物名</label>
            <input class="profile__form-input" type="text" name="building" id="building" value="{{ $address->building ?? '' }}">
        </div>
        <div class="profile__form-group">
            <input type="hidden" id="profile_image_thumbnail_id" name="thumbnail_id" value="">
            <button class="profile__form-button">更新する</button>
        </div>
    </form>
</div>
@endsection