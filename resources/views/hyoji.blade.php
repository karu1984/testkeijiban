@extends('head')
@section('content')
<p>マイページ　ログイン者:{{auth()->user()->name}}</p>
<p>【投稿したポスト新着順】</p>
@foreach ($posts as $post)
<!--投稿の表示-->
<p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
    {{$post->user->name}}
    <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
    {{$post->body}}

<hr>
@endforeach
{!! $posts->links('pagination::bootstrap-5')!!}    

<p>【いいねしたポスト新着順】</p>
@foreach ($l_posts as $l_post)
<!--投稿の表示-->
<p><a href="{{ route('show', $post) }}">{{ $l_post->post->title }}</a>
<hr>
@endforeach

@endsection