{{-- サイドバーのパーツです --}}
@section('sidebar')
    {{-- 自己紹介の部分col-3 --}}
    <div class="col-2">
        <h1 class="fs-4 anim-box slidein is-animated">&nbsp;</h1>
        <div class="card">
            {{-- ユーザ画像表示 --}}
            <p class="m-2 raberu">プロフィール画像</p>
            @auth
                <div style="display: flex; justify-content:center;">
                    <a href="{{ route('userprofile', auth()->user()->id) }}">
                        <img src="{{ asset('storage/images/' . auth()->user()->image) }}" class="p-1 m-1 border border-2"
                            width="140px"></a>
                </div>
                <div class="m-2">
                    <p class="raberu">自己紹介</p>
                        {!! nl2br( Auth::user()->introduction) !!}
                </div>
            @else
                {{-- ログインしてなければデフォルト人影画像表示 --}}
                <img src="{{ asset('storage/images/' . 'デフォルト人影画像.jpg') }}" class="p-2 m-2 img-fluid border border-2"
                    style="height: auto"></a>
                <div class="m-2">
                    <p class="raberu">自己紹介</p>
                    新規登録をして自己紹介を書きましょう‼
                </div>
            @endauth

        </div>
    </div>
@show
