<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous" defer></script>
    <script src="{{ asset('js/hamburger.js')}}" defer></script>
    @yield('js')
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                @auth
                <a class="header__logo" href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo">
                </a>
                @endauth
                @guest
                <a class="header__logo" href="/guest">
                    <img class="header__logo-image" src="{{ asset('images/logo.svg') }}" alt="Logo">
                </a>
                @endguest
                @php
                $specificRoutes = ['login', 'register', 'sell.index', 'purchase.edit.address', 'guest.unauthorized_access'];
                @endphp
                @unless(\Route::currentRouteNamed(...$specificRoutes))
                <form class="search-form" action="/search" method="get">
                    <input class="search-form__keyword-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    <div class="btn__wrap">
                        <button class="search-form__button">検索</button>
                    </div>
                </form>
                <nav class="nav">
                    <ul class="header-nav">
                        @auth
                        <li class="header-nav__item">
                            <form class="form__header" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/my-page">マイページ</a>
                        </li>
                        <form class="form__header" action="/sell" method="get">
                            <button class="header-nav__listing-button">出品</button>
                        </form>
                        @endauth
                        @guest
                        <li class="header-nav__item">
                            <form class="form__header" action="/login" method="get">
                                <button class="header-nav__button">ログイン</button>
                            </form>
                        </li>
                        </li>
                        <li class="header-nav__item">
                            <form class="form__header" action="/register" method="get">
                                <button class="header-nav__button">会員登録</button>
                            </form>
                        </li>
                        <form class="form__header" action="/guest/unauthorized_access" method="get">
                            <button class="header-nav__listing-button">出品</button>
                        </form>
                        @endguest

                    </ul>
                </nav>
                <!-- ハンバーガーメニュー -->
                <!-- クリックする３本線の部分 -->
                <span class="nav_toggle">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
                <!-- クリックで表示されるメニュー -->
                <form class="hamburger__search-form" action="/search" method="get">
                    <input class="search-form__keyword-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    <div class="btn__wrap">
                        <button class="search-form__button">検索</button>
                    </div>
                </form>
                <nav class="hamburger__nav">
                    <ul class="nav_menu_ul">
                        @auth
                        <li class="nav_menu_li">
                            <form class="form__header" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        </li>
                        <li class="nav_menu_li">
                            <a class="header-nav__link" href="/my-page">マイページ</a>
                        </li>
                        @endauth
                        @guest
                        <li class="nav_menu_li">
                            <form class="form__header" action="/login" method="get">
                                <button class="header-nav__button">ログイン</button>
                            </form>
                        </li>
                        </li>
                        <li class="nav_menu_li">
                            <form class="form__header" action="/register" method="get">
                                <button class="header-nav__button">会員登録</button>
                            </form>
                        </li>
                        @endguest
                        <form class="form__header" action="/sell" method="get">
                            <button class="header-nav__listing-button">出品</button>
                        </form>
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