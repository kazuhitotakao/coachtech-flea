@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/admin_users_index.css') }}" rel="stylesheet">
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
                <h2 class="admin-page__heading">ユーザー一覧</h2>
            </div>
        </div>
        <div class="admin-page__search">
            <form class="admin-page__search-form" action="{{ route('admin.users.search') }}" method="get">
                <input class="form-control admin-page__search-keyword-input" name="key" type="text"
                    value="{{ request('key') }}" placeholder="Name or Email">
                <div class="admin-page__search-button-wrapper">
                    <input class="admin-page__search-button" type="submit" value="検索">
                    <input class="admin-page__search-button" name="reset" type="submit" value="リセット">
                </div>
            </form>
        </div>
        <table class="admin-page__table">
            <tr class="admin-page__row">
                <th class="admin-page__label admin-page__label-name">Name</th>
                <th class="admin-page__label admin-page__label-email">Email</th>
                <th class="admin-page__label admin-page__label-mail">Mail</th>
                <th class="admin-page__label admin-page__label-delete">Delete</th>
            </tr>
            @foreach ($users as $user)
                <tr class="admin-page__row">
                    <td class="admin-page__data admin-page__data-name">{{ $user->name }}</td>
                    <td class="admin-page__data admin-page__data-email">{{ $user->email }}</td>
                    <td class="admin-page__data admin-page__data-mail">
                        <a class="admin-page__mail-modal-link" href="#user{{ $user->id }}"><i
                                class="las la-envelope"></i></a>
                        {{-- s mailモーダル --}}
                        <div class="admin-page__mail-modal" id="user{{ $user->id }}">
                            <a class="admin-page__mail-modal-overlay" href="#!"></a>
                            <div class="admin-page__mail-modal-window">
                                <div class="admin-page__mail-modal-content">
                                    <h2 class="admin-page__mail-modal-title">メール送信</h2>
                                    <form class="admin-page__mail-modal-form" action="/mail/admin-to-user" method="get">
                                        <input name="user_id" type="hidden" value="{{ $user->id }}">
                                        <table class="admin-page__mail-modal-table">
                                            <tr class="admin-page__mail-modal-row">
                                                <th class="admin-page__mail-modal-label">宛先</th>
                                                <td class="admin-page__mail-modal-data">
                                                    <div class="admin-page__mail-modal-data-user-name">{{ $user->name }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="admin-page__mail-modal-row">
                                                <th class="admin-page__mail-modal-label">件名</th>
                                                <td class="admin-page__mail-modal-data">
                                                    <input class="form-control admin-page__mail-modal-data-subject"
                                                        name="subject" type="text">
                                                    @error('subject')
                                                        <div class="form__error">
                                                            ※{{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr class="admin-page__mail-modal-row">
                                                <th class="admin-page__mail-modal-label">本文</th>
                                                <td class="admin-page__mail-modal-data">
                                                    <textarea class="form-control admin-page__mail-modal-data-content" name="content" type="text"></textarea>
                                                    @error('content')
                                                        <div class="form__error">
                                                            ※{{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </table>
                                        <button class="admin-page__mail-modal-button">送信</button>
                                    </form>
                                </div>
                                <a class="admin-page__mail-modal-close" href="#!">×</a>
                            </div>
                        </div>
                        {{-- e mailモーダル --}}
                    </td>
                    <td class="admin-page__data admin-page__data-delete">
                        <a class="admin-page__delete-modal-link" href="#delete{{ $user->id }}">
                            <i class="las la-trash"></i>
                        </a>
                        {{-- s deleteモーダル --}}
                        <div class="admin-page__delete-modal" id="delete{{ $user->id }}">
                            <a class="admin-page__delete-modal-overlay" href="#!"></a>
                            <div class="admin-page__delete-modal-window">
                                <div class="admin-page__delete-modal-content">
                                    <h2 class="admin-page__delete-modal-title">削除確認</h2>
                                    <p class="admin-page__delete-modal-text">本当に削除しますか？<br>この操作は取り消せません。</p>

                                    <div class="admin-page__delete-modal-button-wrapper">
                                        <form action="{{ route('admin.users.destroy', ['user_id' => $user->id]) }}"
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
            <tr class="admin-page__row">
                <td colspan="2"></td>
                <td class="admin-page__data admin-page__data-delete">
                    <div class="admin-page__mail-users-modal-link-wrapper">
                        <a class="admin-page__mail-users-modal-link" href="#mail_users">一括送信</a>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
        {{-- s mail_usersモーダル --}}
        <div class="admin-page__mail-modal" id="mail_users">
            <a class="admin-page__mail-modal-overlay" href="#!"></a>
            <div class="admin-page__mail-modal-window">
                <div class="admin-page__mail-modal-content">
                    <h2 class="admin-page__mail-modal-title">メール一括送信</h2>
                    <form class="admin-page__mail-modal-form" action="/mail/admin-to-users" method="get">
                        <input name="users" type="hidden" value="{{ $users }}">
                        <table class="admin-page__mail-modal-table">
                            <tr class="admin-page__mail-modal-row">
                                <th class="admin-page__mail-modal-label">宛先</th>
                                <td class="admin-page__mail-modal-data">
                                    <div class="admin-page__mail-modal-data-user-name">
                                        @foreach ($users as $user)
                                            {{ $user->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr class="admin-page__mail-modal-row">
                                <th class="admin-page__mail-modal-label">件名</th>
                                <td class="admin-page__mail-modal-data">
                                    <input class="form-control admin-page__mail-modal-data-subject" name="subject"
                                        type="text">
                                    @error('subject')
                                        <div class="form__error">
                                            ※{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                            </tr>
                            <tr class="admin-page__mail-modal-row">
                                <th class="admin-page__mail-modal-label">本文</th>
                                <td class="admin-page__mail-modal-data">
                                    <textarea class="form-control admin-page__mail-modal-data-content" name="content" type="text"></textarea>
                                    @error('content')
                                        <div class="form__error">
                                            ※{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                            </tr>
                        </table>
                        <button class="admin-page__mail-modal-button">一括送信</button>

                    </form>
                </div>
                <a class="admin-page__mail-modal-close" href="#!">×</a>
            </div>
        </div>
        {{-- e mail_usersモーダル --}}
    </div>
@endsection
