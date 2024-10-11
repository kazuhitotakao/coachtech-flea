@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/unauthorized_access.css') }}">
@endsection

@section('content')
<div class="unauthorized">
    <div class="unauthorized-card">
        <h3 class="unauthorized-card__title">
            アクセス権限がありません
        </h3>
        <p class="unauthorized-card__text">全ての機能を利用するには、アカウントにログインするか、会員登録をお願いします。</p>
        <div class="unauthorized-card__link-container">
            <a class="unauthorized-card__link" href="/login">ログイン</a>
            <a class="unauthorized-card__link" href="/register">会員登録</a>
        </div>
    </div>
</div>
@endsection