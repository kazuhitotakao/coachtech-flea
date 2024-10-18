<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="{{ asset('js/hamburger.js')}}" defer></script>
    @yield('js')
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__utilities">
                @auth
                <a class="header__logo" href="/">
                    <img class="header__logo--image" src="{{ asset('images/logo.svg') }}" alt="Logo">
                </a>
                @endauth
                @guest
                <a class="header__logo" href="/guest">
                    <img class="header__logo--image" src="{{ asset('images/logo.svg') }}" alt="Logo">
                </a>
                @endguest
                @php
                $specificRoutes = ['login', 'register', 'sell.index', 'purchase.edit.address', 'guest.unauthorized_access', 'item.create'];
                @endphp
                @unless(\Route::currentRouteNamed(...$specificRoutes))
                <form class="header__search-form" action="/search" method="GET">
                    <input class="header__search-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    <div class="btn__wrap">
                        <button class="header__search-button">検索</button>
                    </div>
                </form>
                <nav class="header__nav">
                    <ul class="header__nav-list">
                        @auth
                        <li class="header__nav-item">
                            <form action="/logout" method="POST">
                                @csrf
                                <button class="header__nav-button">ログアウト</button>
                            </form>
                        </li>
                        <li class="header__nav-item">
                            <a class="header__nav-link" href="/my-page/listed">マイページ</a>
                        </li>
                        <form action="/item/create" method="GET">
                            <button class="header__nav-button header__nav-button--listing">出品</button>
                        </form>
                        @endauth
                        @guest
                        <li class="header__nav-item">
                            <form action="/login" method="GET">
                                <button class="header__nav-button">ログイン</button>
                            </form>
                        </li>
                        <li class="header__nav-item">
                            <form action="/register" method="GET">
                                <button class="header__nav-button">会員登録</button>
                            </form>
                        </li>
                        <form action="/guest/unauthorized_access" method="GET">
                            <button class="header__nav-button header__nav-button--listing">出品</button>
                        </form>
                        @endguest

                    </ul>
                </nav>
                <!-- ハンバーガーメニュー -->
                <!-- クリックする３本線の部分 -->
                <span class="header__hamburger-toggle">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
                <!-- クリックで表示されるメニュー -->
                <form class="header__hamburger-search-form" action="/search" method="GET">
                    <input class="header__hamburger-search-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    <div class="btn__wrap">
                        <button class="header__hamburger-search-button">検索</button>
                    </div>
                </form>
                <nav class="header__hamburger-nav">
                    <ul class="header__hamburger-nav-list">
                        @auth
                        <li class="header__hamburger-nav-item">
                            <form action="/logout" method="POST">
                                @csrf
                                <button class="header__hamburger-nav-button">ログアウト</button>
                            </form>
                        </li>
                        <li class="header__hamburger-nav-item">
                            <a class="header__hamburger-nav-link" href="/my-page/listed">マイページ</a>
                        </li>
                        <form action="/item/create" method="GET">
                            <button class="header__hamburger-nav-button header__hamburger-nav-button--listing">出品</button>
                        </form>
                        @endauth
                        @guest
                        <li class="header__hamburger-nav-item">
                            <form action="/login" method="GET">
                                <button class="header__hamburger-nav-button">ログイン</button>
                            </form>
                        </li>
                        <li class="header__hamburger-nav-item">
                            <form action="/register" method="GET">
                                <button class="header__hamburger-nav-button">会員登録</button>
                            </form>
                        </li>
                        <form action="/guest/unauthorized_access" method="GET">
                            <button class="header__hamburger-nav-button header__hamburger-nav-button--listing">出品</button>
                        </form>
                        @endguest
                    </ul>
                </nav>
                @endunless
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>