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

                @if ($post->image)
                    <div class="card border-0">
                        (画像ファイル：{{ $post->image }})
                        <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto d-block" style="height:100px;">
                    </div>
                @endif


                @if ($post->user_id == Auth::user()->id)
                    <a href="{{ route('edit', $post->id) }}"><button class="btn btn-primary">編集する</button></a>
                @endif
                <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか")'>削除</button>
                </form>


                <!--新規コメントの投稿-->
                <form action="/top/{{ $post->id }}/comments" method="post">
                    @csrf
                    <input value="{{ $post->id }}" type="hidden" name="post_id">
                    <input value="{{ Auth::id() }}" type="hidden" name="user_id">
                    <input class="form-control comment-input border mb-5" placeholder="新規コメント ..." type="text"
                        name="comment" />
                </form>


                <!--既存のコメント表示-->
                @foreach ($post->comments->sortByDesc('created_at') as $comment)
                    {{ $comment->comment }}

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
