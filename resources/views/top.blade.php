@extends('head')
@section('content')
    <div class="container">
        <div class="row">
            <h1>投稿記事一覧</h1>
            <div>
                @auth
                    こんにちは{{ $user->name }}さん<br>
                @else
                    未ログイン状態です
                @endauth
            </div>

            <div class="col-6">

                @auth
                    <a href="{{ route('top.create') }}" class="btn btn-primary mb-2">新規投稿ボタン</a>
                @else
                    ログインすると新規の投稿ができます。
                @endauth

                <div class="card p-2">
                    @foreach ($posts as $post)
                        <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </p>
                        投稿者:{{ $post->user->name }}
                        <p>{{ $post->body }}</p>
                        @if ($post->image)
                            <div class="card border-0">
                                (画像ファイル：{{ $post->image }})
                                <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto d-block"
                                    style="height:50px;">
                            </div>
                        @endif
                        <!--コメント件数カウント-->
                        @if ($post->comments->count())
                        コメント件数:{{$post->comments->count()}}件
                        @else
                        コメントはまだありません。    
                        @endif



                        <hr>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
