<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--ユーザフォローのため追加-->
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>テスト掲示板</title>
    <!-- ブートストラップ　css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- ブートストラップ　アイコン -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="{{url('top')}}"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">シンプル掲示板</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">新規登録</a></li>
                <input type="text" placeholder="search">
                <button class="btn btn-primary mx-1">検索</button>
            </ul>
        </header>
        @yield('content')
        <footer class="justify-content-center mt-auto py-3 mb-4 bg-body-tertiary">

            <a href="{{ url('top') }}"><span class="text-body-secondary">トップへ</span><a>
        </footer>
    </div>
</body>

</html>
