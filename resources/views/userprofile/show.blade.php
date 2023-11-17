@extends('head')
@section('content')
    <div class="row justify-content-center">

        <!--自己紹介があれば表示-->
        <div class="col-7">
            <h4>投稿したユーザのプロフィールページです</h4>
            @if (isset($userprofile->id))
                <div class="row">
                    <!--画像があれば表示-->
                    <div class="col-2 m-2">
                        <img src="{{ asset('storage/images/' . $user->image) }}" class="img-fluid rounded-circle">
                    </div>
                    <div class="col">
                        ユーザID:{{ $user->id }}<br>
                        ユーザ氏名:{{ $user->name }}<br>
                        紹介:{{ $userprofile->introduction }}<br>
                    </div>
                </div>
                <!--自己紹介が登録されてなければ表示-->
            @else
                自己紹介がありません
            @endif

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
                    <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                        {{ $post->user->name }}
                    <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
                    {{ $post->body }}

                    <hr>
                @endforeach
            @endif

        </div>

    </div>
@endsection
