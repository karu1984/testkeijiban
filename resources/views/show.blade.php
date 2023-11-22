@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')


            {{-- コンテンツ本体 --}}
            <div class=col-7>
                <h1 class="fs-4 my-2 anim-box slidein is-animated"> 記事詳細画面</h1>
                <div class="card">
                    {{-- 投稿ヘッド部分行、投稿者画像、名前、投稿日時 --}}
                    <div class="row">
                        <div class="col-2">
                            {{-- ユーザ画像表示 --}}
                            <a href="{{ route('userprofile.show', $post->user->id) }}">
                                <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                    class="m-2 mask border border-1"></a>
                        </div>
                        {{-- 投稿タイトル --}}
                        <div class="col mx-1 my-1">
                            <a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                        </div>
                        <div class="col text-end mx-1 my-1">
                            <a href="{{ route('userprofile.show', $post->user->id) }}">投稿者:{{ $post->user->name }}</a>
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <!--投稿に画像があれば表示-->
                    @if ($post->image)
                        <div class="col-6 align-self-center">
                            <img src="{{ asset('storage/images/' . $post->image) }}" class="img-fluid rounded-3">
                        </div>
                    @endif
                    {{-- 記事本文 --}}
                    <div class="row">
                        {{-- 隙間をあけるためのcol-2 --}}
                        <div class="col-2 mx-4"></div>
                        <div class="col">
                            <p>{!! nl2br($post->body) !!}</p>
                        </div>
                        <!--ログインしてれば表示-->
                        @auth
                            <div class="row"></div>
                            <div class="col-2"></div>
                            <div class="col mb-1">
                                <div class="btn-group" role="group">
                                    {{-- 記事投稿者がログインユーザならば表示 --}}
                                    @if ($post->user_id == Auth::user()->id)
                                        {{-- 記事編集 --}}
                                        <a href="{{ route('edit', $post->id) }}"><button class="btn btn-light mx-5"><i
                                                    class="bi bi-pencil-square "></i></button></a>
                                        {{-- 記事削除 --}}
                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light mx-5"
                                                onclick='return confirm("削除しますか")'><i class="bi bi-trash3"></i></button>
                                        </form>
                                    @endif
                                </div>
                                <!--ログインユーザすでにいいねしてる場合-->
                                
                                @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                    <a href="{{ route('unlike', $post) }}">
                                        <i class="bi bi-heart-fill unlike-btn"></i></a>
                                    <span class="likecount">{{ $post->likes->count() }}</span>
                                    <!--ログインユーザがいいねしてなかった場合-->
                                @else
                                    <a href="{{ route('like', $post) }}">
                                        <i class="bi bi-heart-fill like-btn"></i></a>
                                    <span>{{ $post->likes->count() }}</span>
                                @endif
                                
                            </div>
                        </div>
                        <!--ログインユーザのみ、新規コメントの投稿-->

                        <form action="/top/{{ $post->id }}/comments" method="post">
                            @csrf
                            <input value="{{ $post->id }}" type="hidden" name="post_id">
                            <div class="formgroup card border border-gray mb-2">
                                <textarea class="mb-2" name="comment" id="" rows="3"></textarea>
                                <div class="text-end">
                                    <input class="btn btn-success btn-sm  " type="submit" value="送信">
                                </div>
                                @error('comment')
                                    <span style="color:red;">コメントを255文字以内で入力してください</span>
                                @enderror

                            </div>
                        </form>
                    @else
                        <!--ログインしていないユーザの場合いいね数のみ表示-->
                        <div class="row"></div>
                        <div class="col-2"></div>
                        <div class="col">
                        <i class="bi bi-heart-fill like-btn">{{ $post->likes->count() }}</i>
                        </div>

                        <hr>
                    @endauth

                    <!--既存のコメント表示-->
                    @foreach ($post->comments->sortByDesc('created_at') as $comment)
                        {{-- ユーザ画像表示 --}}
                        <div style="display: flex;">
                            <div>
                                <a href="{{ route('userprofile.show', $comment->user->id) }}">
                                    <img src="{{ asset('storage/images/' . $comment->user->image) }}"
                                        class="m-2 mask-head border border-1"></a>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('userprofile.show', $comment->user->id) }}">
                                    投稿者:{{ $comment->user->name }}</a>
                                {{ $comment->created_at->diffForHumans() }}
                            </div>

                        </div>
                        {{-- 改行表示のためのnl2br --}}
                        <div class="mx-2">
                            {!! nl2br($comment->comment) !!}
                        </div>
                        <!--コメント削除-->
                        @if ($comment->user->id == Auth::id())
                            <div class="text-end">
                                <form action="/top/show/{{ $comment->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn  btn-sm btn-light mx-3"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        @endif
                        <hr>
                    @endforeach
                </div>
            </div>

            {{-- サイドバーパーツ、広告など --}}
            @include('sidepop')
        </div>
    @endsection
