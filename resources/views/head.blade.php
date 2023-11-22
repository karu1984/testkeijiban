<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
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
    <div class="container">
        <header class="d-flex border-bottom top-header">
            <a href="{{ url('top') }}"
                class="fs-4 d-flex align-items-center link-body-emphasis text-decoration-none mx-3">
                <span>シンプル掲示板</span>
            </a>


            
            {{-- 検索機能 --}}
            <form method="get" action="{{ route('post.search') }}">
                <div class="form-group input-group my-2">
                    <input type="text" name="keyword" class="form-control" placeholder="タイトル検索"
                        value="{{ request()->input('keyword') }}"autocomplete="on">
                    <button type="submit" class="btn btn-light btn-sm m-1"><i class="bi bi-search"></i></button>
                </div>
            </form>



            <div class="d-flex align-items-end " style="margin-left:150px;">
                @auth
                    {{-- ユーザ画像表示 --}}
                    <a href="{{ route('userprofile', auth()->user()->id) }}">
                        <img src="{{ asset('storage/images/' . auth()->user()->image) }}"
                            class="m-1 mask-head border border-1"></a>
                    <span class="mb-2"> こんにちは{{ auth()->user()->name }}さん</span>

                    <div class="d-flex align-items-end">
                        <ul class="nav nav-pills ">
                            <li class="nav-item"><a class=" nav-link" href="{{ route('userprofile') }}">マイページ</a> </li>
                            {{-- 新規投稿 --}}
                            <li class="nav-item"><a class=" nav-link" href="{{ route('top.create') }}">新規投稿</a></li>
                        </ul>
                    </div>
                @else
                    ログインすると新規投稿などができます。
                @endauth



                {{-- ログイン、ログアウト --}}
                <div class="d-flex align-items-end">
                    <ul class="nav nav-pills ">
                        @auth
                            {{-- ログアウトボタン、ナビリンククラスで下線なしになった。 --}}
                            <li class="nav-item">
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="nav-link">ログアウト</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">新規登録</a></li>
                        @endauth
                    </ul>
                </div>
            </div>

        </header>

        @yield('content')
        <footer class="d-flex mt-auto py-3 mb-4 bg-body-tertiary">

            <a href="{{ url('top') }}"><span class="text-body-secondary">トップへ</span><a>
        </footer>
    </div>
    <script src="{{asset('/js/app.js') }}"></script>

</body>

</html>
