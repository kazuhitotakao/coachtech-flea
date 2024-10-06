@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/unauthorized_access.css') }}">
@endsection

@section('content')
<div class="unauthorized__content">
    <div class="card">
        <h3 class="card__title">
            アクセス権限がありません
        </h3>
        <p class="card__text">全ての機能を利用するには、アカウントにログインするか、会員登録をお願いします。</p>
        <div class="card__link-container">
            <a class="card__link" href="/login">ログイン</a>
            <a class="card__link" href="/register">会員登録</a>
        </div>
    </div>
</div>
@endsection