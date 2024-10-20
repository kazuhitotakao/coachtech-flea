@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="login__form-heading">
        <h2>ログイン</h2>
    </div>
    <form class="form" action="/login" method="POST">
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <label for="email">メールアドレス</label>
                    <input class="form-control" type="mail" name="email" id="email" value="{{ old('email') }}" />
                </div>
                @error('email')
                <div class="form__error">
                    ※{{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <label for="password">パスワード</label>
                    <input class="form-control" type="password" name="password" id="password" />
                </div>
                @error('password')
                <div class="form__error">
                    ※{{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログインする</button>
        </div>
    </form>
    <div class="register-link">
        <a class="register-button" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection