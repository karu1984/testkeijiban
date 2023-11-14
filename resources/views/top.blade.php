@extends('head')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>投稿記事一覧</h1>


                @auth
                    こんにちは{{ $user->name }}さん

                    <a href="{{ url('hyoji') }}" class="btn btn-secondary mb-2">
                        マイページ</a>
                @else
                    未ログイン状態です
                @endauth

                <!--自己紹介とかのページ-->
                @auth
                    <a href="{{ route('userprofile') }}" class="btn btn-primary mb-2">自己紹介ページ</a>
                @else
                    ログインすると新規の投稿ができます。
                @endauth



                @auth
                    <a href="{{ route('top.create') }}" class="btn btn-primary mb-2">新規投稿ボタン</a>
                @else
                    ログインすると新規の投稿ができます。
                @endauth

                <div class="card p-2">
                    @foreach ($posts as $post)
                        <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                        <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
                        </p>
                        <a href="{{ route('userprofile.show', $post->user->id) }}">投稿者:{{ $post->user->name }}</a>
                        <p>{{ $post->body }}</p>
                        <!--画像があれば表示-->
                        @if ($post->image)
                            <div class="card border-0">
                                <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto d-block"
                                    style="height:50px;">
                            </div>
                        @endif
                        <!--コメント件数カウント-->
                        @if ($post->comments->count())
                        <i class="bi bi-chat">{{ $post->comments->count() }}件</i>
                        @else
                        <i class="bi bi-chat">0件</i>
                        @endif
                        <!--いいねのカウント-->
                        <i class="bi bi-heart">{{ $post->likes->count() }}件</i>
                        <hr>
                    @endforeach
                    {!! $posts->links('pagination::bootstrap-5') !!}
                </div>
            </div>

        </div>
    </div>
@endsection
