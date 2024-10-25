@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/admin_comments_index.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if (session('message'))
        <div class="alert alert-success custom-success alert-dismissible fade show" role="alert">
            {!! session('message') !!}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @endif
    <a class="admin-page__users" href="/admin-page/users">ユーザー管理</a>
    <a class="admin-page__comments" href="/admin-page/comments">コメント管理</a>
    <hr>
    <div class="admin-page">
        <div class="admin-page__name-container">
            <div class="admin-page__name">
                <h2 class="admin-page__heading">コメント一覧</h2>
            </div>
        </div>
        <div class="admin-page__search">
            <form class="admin-page__search-form" action="{{ route('admin.comments.search') }}" method="get">
                <input class="form-control admin-page__search-keyword-input" name="key" type="text"
                    value="{{ request('key') }}" placeholder="Name or Item or Comment">
                <div class="admin-page__search-button-wrapper">
                    <input class="admin-page__search-button" type="submit" value="検索">
                    <input class="admin-page__search-button" name="reset" type="submit" value="リセット">
                </div>
            </form>
        </div>
        <table class="admin-page__table">
            <tr class="admin-page__row">
                <th class="admin-page__label admin-page__label-name">Name</th>
                <th class="admin-page__label admin-page__label-item">Item</th>
                <th class="admin-page__label admin-page__label-comment">Comment</th>
                <th class="admin-page__label admin-page__label-delete">Delete</th>
            </tr>
            @foreach ($comments as $comment)
                <tr class="admin-page__row">
                    <td class="admin-page__data admin-page__data-name">{{ $comment->user->name }}</td>
                    <td class="admin-page__data admin-page__data-item">{{ $comment->item->name }}</td>
                    <td class="admin-page__data admin-page__data-comment">{{ $comment->comment }}</td>
                    <td class="admin-page__data admin-page__data-delete">
                        <a class="admin-page__delete-modal-link" href="#delete{{ $comment->id }}">
                            <i class="las la-trash"></i>
                        </a>
                        {{-- s deleteモーダル --}}
                        <div class="admin-page__delete-modal" id="delete{{ $comment->id }}">
                            <a class="admin-page__delete-modal-overlay" href="#!"></a>
                            <div class="admin-page__delete-modal-window">
                                <div class="admin-page__delete-modal-content">
                                    <h2 class="admin-page__delete-modal-title">削除確認</h2>
                                    <p class="admin-page__delete-modal-text">本当に削除しますか？<br>この操作は取り消せません。</p>

                                    <div class="admin-page__delete-modal-button-wrapper">
                                        <form action="{{ route('admin.comments.destroy', ['comment_id' => $comment->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="admin-page__delete-modal-button">削除する</button>
                                        </form>
                                        <form action="#!" method="GET">
                                            <button class="admin-page__delete-modal-button">キャンセル</button>
                                        </form>
                                    </div>
                                </div>
                                <a class="admin-page__delete-modal-close" href="#!">×</a>
                            </div>
                        </div>
                        {{-- e deleteモーダル --}}
                    </td>

                </tr>
            @endforeach
        </table>
    </div>
@endsection
