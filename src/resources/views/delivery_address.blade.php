@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/delivery_address.css') }}">
@endsection

@section('content')


<h2>配送先の変更</h2>

<form action="{{ route('purchase.update.address', ['item_id' => $item->id]) }}" method="post">
    @csrf
    <button>更新する</button>
</form>

@endsection