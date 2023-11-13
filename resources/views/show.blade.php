@extends('head')
@section('content')
    <div class="container">
        <div class="row">
            <div class=col-6>
                <h1> 記事詳細画面</h1>
                <div class="card">
                    タイトル<p>{{ $post->title }}</p>
                </div>
                <div class="card">
                    本文<p>{{ $post->body }}</p>
                </div>
                <!--画像があれば表示-->
                @if ($post->image)
                    <div class="card border-0">
                        (画像ファイル：{{ $post->image }})
                        <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto d-block" style="height:100px;">
                    </div>
                @endif
                <!--ログインしてれば表示-->
                @auth
                    <!--ログインユーザ＝投稿者のとき表示-->
                    @if ($post->user_id == Auth::user()->id)
                        <a href="{{ route('edit', $post->id) }}"><button class="btn btn-primary">編集する</button></a>

                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか")'>削除</button>
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


                    <!--ログインユーザのみ、新規コメントの投稿-->
                    <form action="/top/{{ $post->id }}/comments" method="post">
                        @csrf
                        <input value="{{ $post->id }}" type="hidden" name="post_id">
                        <input value="{{ Auth::id() }}" type="hidden" name="user_id">
                        <input class="form-control comment-input border mb-5" placeholder="新規コメント ..." type="text"
                            name="comment" />
                    </form>
                @else
                    <!--ログインしていないユーザの場合いいね数のみ表示-->
                    <p>いいね件数:{{ $post->likes->count() }}</p>
                @endauth


                <!--既存のコメント表示-->
                @foreach ($post->comments->sortByDesc('created_at') as $comment)
                    {{ $comment->comment }}
                    <span>投稿者:{{ $post->user->name }}</span>
                    <div class="text-end"><span>{{ $comment->created_at->diffForHumans() }}</span></div>

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
