@extends('head')
@section('content')
    <div class="container">
        <div class="row">
            <div class=col-7>
                <h1> 記事詳細画面</h1>
                <div class="card">
                    <div class="row">
                        <div class="col-2">
                            {{-- ユーザ画像表示 --}}
                            <a href="{{ route('userprofile.show', $post->user->id) }}">
                                <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                    class="m-2 img-fluid rounded-circle"></a>
                        </div>
                        {{-- 投稿タイトル --}}
                        <div class="col">
                            <a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('userprofile.show', $post->user->id) }}">投稿者:{{ $post->user->name }}</a>
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                        
                    </div>




                    <!--画像があれば表示-->
                    @if ($post->image)
                        <div class="col-6 align-self-center">
                            <img src="{{ asset('storage/images/' . $post->image) }}" class="img-fluid">
                        </div>
                    @endif

                    {{-- 記事本文 --}}
                    <p>{{ $post->body }}</p>

                    <!--ログインしてれば表示-->
                    @auth
                    <div>
                        <!--ログインユーザ＝投稿者のとき表示-->
                        @if ($post->user_id == Auth::user()->id)
                            <a href="{{ route('edit', $post->id) }}"><button class="btn btn-primary">編集</button></a>

                            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick='return confirm("削除しますか")'>削除</button>
                            </form>
                        @endif
                        <!--ログインユーザすでにいいねしてる場合-->
                       
                            @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                <a href="{{ route('unlike', $post) }}" class="btn btn-success btn-sm">
                                    いいねを消す
                                    <span class="badge">{{ $post->likes->count() }}</span>
                                </a>
                                <!--ログインユーザがいいねしてなかった場合-->
                            @else
                                <a href="{{ route('like', $post) }}" class="btn btn-secondary btn-sm">
                                    いいね
                                    <span class="badge">{{ $post->likes->count() }}</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!--ログインユーザのみ、新規コメントの投稿-->
                    
                    <form action="/top/{{ $post->id }}/comments" method="post">
                        @csrf
                        <input value="{{ $post->id }}" type="hidden" name="post_id">
                        <input value="{{ Auth::id() }}" type="hidden" name="user_id">
                        <input class="form-control form-control-lg comment-input border mb-5" placeholder="新規コメント ..."
                            type="text" name="comment" />
                    </form>
                @else
                    <!--ログインしていないユーザの場合いいね数のみ表示-->
                    <p>いいね件数:{{ $post->likes->count() }}</p>
                @endauth


                <!--既存のコメント表示-->
                @foreach ($post->comments->sortByDesc('created_at') as $comment)
                    {{ $comment->comment }}
                    <a href="{{ route('userprofile.show', $post->user->id) }}">
                        投稿者:{{ $post->user->name }}</a>
                    {{ $comment->created_at->diffForHumans() }}

                    <!--コメント削除-->
                    @if ($comment->user->id == Auth::id())
                        <div class="text-end">
                            <form action="/top/show/{{ $comment->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn  btn-sm btn-danger">削除</button>
                            </form>
                        </div>
                    @endif
                    <hr>
                @endforeach

            </div>

        </div>

    </div>
@endsection
