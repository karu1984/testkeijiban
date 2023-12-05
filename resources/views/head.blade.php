<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    {{-- ユーザの端末情報を取得 --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--ユーザフォローのため追加-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>テスト掲示板</title>
    <!-- ブートストラップ　css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- ブートストラップ　アイコン -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- 自作CSS --}}
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

</head>

<body>
    <div class="container-lg">
        <header class="d-flex border-bottom top-header phone-head-size">
            {{-- トップページタイトル --}}
            <a href="{{ url('top') }}" class="fs-4 align-items-center link-body-emphasis text-decoration-none m-3">
                <span>シンプル掲示板</span>
            </a>
            {{-- スマホ時非表示：検索機能 --}}
            <form class="my-2 me-auto" method="get" action="{{ route('post.search') }}">
                <div class="input-group my-2 me-3 search-none phone-none">
                    <input type="text" name="keyword" class="form-control" placeholder="タイトル検索"
                        value="{{ request()->input('keyword') }}"autocomplete="on">
                    <button type="submit" class="btn btn-light btn-sm me-3"><i class="bi bi-search"></i></button>
                </div>
            </form>
            {{-- スマホ時表示：ハンバーガーメニュー --}}
            @auth
                <div class="hamburger-menu">
                    <input type="checkbox" id="menu-btn-check">
                    <label for="menu-btn-check" class="menu-btn"><span></span></label>
                    <!--ここからメニュー-->
                    <div class="menu-content">
                        <div class="mx-2 my-2">
                            <a href="{{ route('userprofile', auth()->user()->id) }}">
                                <img src="{{ asset('storage/images/' . auth()->user()->image) }}"
                                    class="m-1 mask-head border border-1"></a><br>
                            <span class="my-2 phone-moji" style="color: aliceblue"> {{ auth()->user()->name }}さん</span>
                        </div>
                        <ul>
                            <li>
                                <a href="{{ route('userprofile') }}"><i class="bi bi-person-circle me-3"></i>マイページ</a>
                            </li>
                            <li>
                                <a href="{{ route('top.create') }}"><i class="bi bi-pencil-fill me-3"></i>新規投稿</a>
                            </li>
                            <li>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="nav-link phone-head"> <i class="bi bi-door-open-fill me-3"></i>ログアウト</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                </a>
                            </li>
                            <li>
                                <a>
                                    {{-- 検索のボタン --}}
                                    <input type="checkbox" id="search-btn-check">
                                    <label for="search-btn-check" class="white-moji"><i
                                            class="bi bi-search me-3"></i>タイトル検索</label>

                                    {{-- スマホ時の検索窓 --}}
                                    <div class="hidden-search" id="search-content">
                                        <form class="hidden-search" method="get" action="{{ route('post.search') }}">
                                            <div class="hidden-search input-group my-2">
                                                <input type="text" name="keyword" class="form-control"
                                                    placeholder="タイトル検索"
                                                    value="{{ request()->input('keyword') }}"autocomplete="on">
                                                <button type="submit" class="btn btn-light btn-sm m-1"><i
                                                        class="bi bi-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--ここまでメニュー-->
                </div>
            @else
                {{-- 未ログインの場合のハンバーガーメニュー --}}
                <div class="hamburger-menu">
                    <input type="checkbox" id="menu-btn-check">
                    <label for="menu-btn-check" class="menu-btn"><span></span></label>
                    <!--ここからメニュー-->
                    <div class="menu-content">
                        <br>
                        <div class="ms-3 white-moji"> 未ログインです</div>
                        <ul>
                            <li>
                                <a class="nav nav-link" href="{{ route('login') }}" class="nav-link">
                                    <i class="bi bi-door-closed-fill me-3"></i>ログイン</a>
                            </li>
                            <li>
                                <a class="nav nav-link" href="{{ route('register') }}" class="nav-link">
                                    <i class="bi bi-person-vcard me-3"></i>新規登録</a>
                            </li>
                            <li>
                                <a>
                                    {{-- 検索のボタン --}}
                                    <input type="checkbox" id="search-btn-check">
                                    <label for="search-btn-check" class="white-moji"><i
                                            class="bi bi-search me-3"></i>タイトル検索</label>

                                    {{-- スマホ時の検索窓 --}}
                                    <div class="hidden-search" id="search-content">
                                        <form class="hidden-search" method="get" action="{{ route('post.search') }}">
                                            <div class="hidden-search input-group my-2">
                                                <input type="text" name="keyword" class="form-control"
                                                    placeholder="タイトル検索"
                                                    value="{{ request()->input('keyword') }}"autocomplete="on">
                                                <button type="submit" class="btn btn-light btn-sm m-1"><i
                                                        class="bi bi-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!--ここまでメニュー-->
                </div>
            @endauth


            {{-- スマホ時非表示ナビリンクメニュー --}}
            <div class="d-flex">
                @auth
                    {{-- ユーザ画像表示 --}}
                    <div class="phone-none">
                        <a href="{{ route('userprofile', auth()->user()->id) }}">
                            <img src="{{ asset('storage/images/' . auth()->user()->image) }}"
                                class="m-1 mask-head border border-1"></a>
                    </div>

                    <div class="d-flex phone-moji nav-moji">
                        {{-- ユーザー名前 --}}
                        <p class="phone-head my-2"> {{ auth()->user()->name }}さん</p>
                        {{-- マイページ --}}
                        <a class="nav nav-link phone-head" href="{{ route('userprofile') }}">マイページ</a> </li>
                        {{-- 新規投稿 --}}
                        <a class="nav nav-link phone-head" href="{{ route('top.create') }}">新規投稿</a></li>
                    </div>

                @endauth
                {{-- ログイン、ログアウト、新規登録 --}}
                <div class="d-flex phone-none nav-moji">
                    @auth
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="phone-none nav nav-link">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a class="phone-none nav nav-link"href="{{ route('login') }}">ログイン</a>
                        <a class="phone-none nav nav-link" href="{{ route('register') }}">新規登録</a>
                    @endauth
                </div>
            </div>
        </header>

        {{-- コンテンツ本体 --}}
        @yield('content')

        {{-- フッター --}}
        <footer class="d-flex py-2 mb-4 my-2 bg-warning">
            <a href="{{ url('top') }}"><span class="text-body-secondary">トップへ</span><a>
        </footer>
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>

</body>

</html>
