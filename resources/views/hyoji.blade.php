@extends('head')
@section('content')

    <p>マイページ　ログイン者:{{ auth()->user()->name }}</p>

    <div class="justify-content-center mt-auto py-0 mb-2 bg-body-tertiary">投稿したポスト新着</div>

                     

    <!--投稿の表示-->
    @foreach ($posts as $post)
        <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
            {{ $post->user->name }}
        <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
        {{ $post->body }}

        <hr>
    @endforeach
    {!! $posts->links('pagination::bootstrap-5') !!}

    <div class="justify-content-center mt-auto py-0 mb-2 bg-body-tertiary">いいねポスト、いいね順</div>
    <!--投稿の表示-->
    @foreach ($l_posts as $l_post)
        <p><a href="{{ route('show', $post) }}">{{ $l_post->post->title }}</a>
            {{ $l_post->post->user->name }}
        <div class="text-end"><span>{{ $l_post->post->created_at->diffForHumans() }}</span></div>
        {{ $l_post->post->body }}
        <hr>
    @endforeach
@endsection
