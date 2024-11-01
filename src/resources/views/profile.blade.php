@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/user_image_upload.js') }}" defer></script>
@endsection

@section('css')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
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
    <div class="profile__title">
        <h2>プロフィール設定</h2>
    </div>

    {{-- アップロードされた画像のプレビュー --}}
    <div class="profile-image">
        @if (!empty($image_urls))
            <div class="profile-image-thumbnail__wrapper">
                <div class="profile-image-thumbnail">
                    @if (empty($image_url_thumbnail))
                        <img src="{{ asset('images/user_no-name.jpeg') }}" alt="user_thumbnail">
                    @else
                        <img src="{{ $image_url_thumbnail }}" alt="user_thumbnail">
                    @endif
                </div>

                <h3 class="profile-image-thumbnail-title">※ サムネイル画像を選択してください</h3>
                <div class="profile-images">
                    @foreach ($image_urls as $image_url)
                        <label for="{{ $image_url['id'] }}">
                            <input id="{{ $image_url['id'] }}" name="thumbnail_id" type="radio"
                                value="{{ $image_url['id'] }}" style="display: none;"
                                onclick="updateThumbNailId(this.value);"
                                {{ old('thumbnail_id') == $image_url['id'] ? 'checked' : '' }}>
                            <img class="profile-images_image  {{ old('thumbnail_id') == $image_url['id'] ? 'selected-image' : '' }}"
                                src="{{ $image_url['url'] }}" alt="uploaded image">
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
                    <input id="images" name="images[]" type="file" style="display: none;" multiple>
                    <p id="file_names">選択されたファイルはありません。</p>
                    <div class="profile-image__button">
                        <button class="profile-image__upload-btn" id="image_button" type="submit">アプロード</button>
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
                <input class="profile__form-input form-control" id="user_name" name="user_name" type="text"
                    value="{{ old('user_name', $user->name) }}">
            </div>
            <div class="profile__form-group">
                <label class="profile__form-label" for="postcode">郵便番号</label>
                <input class="profile__form-input form-control" id="postcode" name="postcode" type="number"
                    value="{{ old('postcode', $address->postcode ?? '') }}">
            </div>
            <div class="profile__form-group">
                <label class="profile__form-label" for="address">住所</label>
                <input class="profile__form-input form-control" id="address" name="address" type="text"
                    value="{{ old('address', $address->address ?? '') }}">
            </div>
            <div class="profile__form-group">
                <label class="profile__form-label" for="building">建物名</label>
                <input class="profile__form-input form-control" id="building" name="building" type="text"
                    value="{{ old('building', $address->building ?? '') }}">
            </div>
            <div class="profile__form-group">
                <input id="profile_image_thumbnail_id" name="thumbnail_id" type="hidden"
                    value="{{ old('thumbnail_id') }}">
                <button class="profile__form-button">更新する</button>
            </div>
        </form>
    </div>
@endsection
