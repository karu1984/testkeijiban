@extends('head')
@section('content')
    <h4>投稿したユーザのプロフィールページです</h4>



    <!--自己紹介があれば表示-->
    <div class="col-7">
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
        <!--ログインユーザすでにいいねしてる場合-->

        {{-- @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1) --}}
            {{-- <a href="{{ route('userunlike', $user) }}" class="btn btn-success btn-sm">
                いいねを消す
                {{-- <span class="badge">{{ $post->likes->count() }}</span> --}}
            {{-- </a> --}} 
            <!--ログインユーザがいいねしてなかった場合-->
        {{-- @else --}}
            <a href="{{ route('userlike', $user->id) }}" class="btn btn-secondary btn-sm">
                いいね
                {{-- <span class="badge">{{ $post->likes->count() }}</span> --}}
            </a>
        {{-- @endif --}}
        <div class="justify-content-center mt-auto py-0 mb-2 bg-body-tertiary">投稿したポスト新着</div>

        @if (isset($user->id))
            <!--投稿の表示-->
            @foreach ($posts as $post)
                <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                    {{ $post->user->name }}
                <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
                {{ $post->body }}

                <hr>
            @endforeach
        @endif

    </div>


@endsection
