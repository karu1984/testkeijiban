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

    <style>
.mask {
  position: relative;
  width: 100px;
  height: 100px;
  border-radius: 100%;
  overflow: hidden;
  z-index: 0;
}
.mask-head {
  position: relative;
  width: 50px;
  height: 50px;
  border-radius: 100%;
  overflow: hidden;
  z-index: 0;
}


        .unlike-btn {
            color: #e54747;
            margin-left: 20px;
        }

        .likecount {
            color: #e54747;
        }

        .like-btn {
            color: #968b8b;
            margin-left: 20px;
        }


        .grayscale-img {
            max-width: 320px;
            height: 213px;
            margin: 0;
            padding: 0;
            background: #fff;
            overflow: hidden;
            cursor: pointer;
        }

        .grayscale-img img {
            width: 100%;
            height: 100%;
        }

        /*ホバーエフェクト*/
        .grayscale-img img {
            transition: .3s ease-in-out;
        }

        .grayscale-img:hover img {
            filter: grayscale(100%);
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="{{ url('top') }}"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">シンプル掲示板</span>
            </a>
            <table>
                <tr>
                    <td>
                        <ul class="nav nav-pills">
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
                            {{-- 検索機能のテスト --}}
                            <form method="get" action="{{ route('post.search') }}" class="d-inline-block w-50">
                                <div class="form-group ">
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control" placeholder="検索"
                                            value="{{ request()->input('keyword') }}"autocomplete="on">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-light mx-1"><i
                                                    class="bi bi-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>

                        @auth
                            {{-- ユーザ画像表示 --}}
                            <a href="{{ route('userprofile.show', auth()->user()->id) }}">
                                <img src="{{ asset('storage/images/' . auth()->user()->image) }}"
                                    class="m-2 mask-head img-fluid border border-1" height="5px"></a>
                            こんにちは{{ auth()->user()->name }}さん
                            <a href="{{ route('userprofile') }}" class="btn btn-success mb-2">マイページ</a>
                            {{-- 新規投稿 --}}
                            <a href="{{ route('top.create') }}" class="btn btn-primary mb-2 px-2"><i
                                    class="bi bi-pen-fill px-2"></i></a>
                        @else
                            ログインするとマイページ閲覧、ポストの新規投稿ができます。
                        @endauth

                    </td>
                </tr>
            </table>
        </header>
        @yield('content')
        <footer class="justify-content-center mt-auto py-3 mb-4 bg-body-tertiary">

            <a href="{{ url('top') }}"><span class="text-body-secondary">トップへ</span><a>
        </footer>
    </div>
    <script src="{{ asset('resources/js/testdayo.js') }}"></script>

</body>

</html>
