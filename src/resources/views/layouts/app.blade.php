<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="header__logo" href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo">
                </a>
                @if (Auth::check())
                <input class="search-form__keyword-input" type="text" name="keyword" placeholder="なにをお探しですか？">
                <nav>
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <form class="form__header" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="">マイページ</a>
                        </li>
                        <form class="form__header" action="" method="get">
                            <button class="header-nav__listing-button">出品</button>
                        </form>
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>