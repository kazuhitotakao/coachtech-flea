@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')


<h1>プロフィール設定</h1>

<form action="/my-page/profile" method="post">
    @csrf
    <button>更新する</button>
</form>

@endsection