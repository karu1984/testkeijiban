@extends('head')
@section('content')
    <div class="row justify-content-center">

        {{-- サイドバーパーツ自己紹介など --}}
        @include('sidebar')


        {{-- 自己紹介などコンテンツ本体 --}}
        <!--自己紹介があれば表示-->
        <div class="col-7 phone-body">
            <h4 class="mt-2  anim-box slidein is-animated">投稿したユーザのプロフィールページです</h4>
            <!--画像があれば表示-->
            <div class="col-2 m-2">
                <img src="{{ asset('storage/images/' . $user->image) }}" class="mask">
            </div>
            <div class="col">
                ユーザID:{{ $user->id }}<br>
                ユーザ氏名:{{ $user->name }}<br>
                紹介:{{ $user->introduction }}<br>
            </div>


            {{-- フォロー用のボタン --}}
            {{-- if表示されてるユーザがモデルのfollowusersリレーションでフォローしてるユーザと
            ログインユーザの条件が一致するレコードが1ならば --}}
            @auth
                <div class="text-end">
                    @if ($user->followusers()->where('following_user_id', Auth::user()->id)->count() == 1)
                        <a href="{{ route('unfollow', $user) }}" class="btn btn-danger btn-sm">
                            フォローを外す
                        </a>
                    @else
                        <a href="{{ route('follow', $user) }}" class="btn btn-success btn-sm">
                            フォローする
                        </a>
                    @endif
                </div>
            @endauth

            <!--投稿の表示-->
            <div class="justify-content-center mt-auto py-0 mb-2 bg-body-tertiary">投稿したポスト新着</div>
            @if (isset($user->id))
                @foreach ($posts as $post)
                    <div class="d-flex">
                        <a class="blue-moji nav-link me-auto" href="{{ route('show', $post) }}">{{ $post->title }}</a>
                        {{ $post->user->name }}
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="mx-2" id="word-break">
                        {{ nl2br($post->body) }}
                    </div>
                    <hr>
                @endforeach

                {!! $posts->links('pagination::bootstrap-5') !!}
            @endif

        </div>

        {{-- サイドバーパーツ、広告など --}}
        {{-- @include('sidepop') --}}

    </div>
@endsection
