@extends('head')
@section('content')
    <div class="container">

        <div class="row  justify-content-center">
            <div class="col-7">
                <h1>検索記事一覧</h1>
                <div class="card p-2">
                    @foreach ($posts as $post)
                        <div class="row">
                            <div class="col-2">
                                {{-- ユーザ画像表示 --}}
                                <a href="{{ route('userprofile.show', $post->user->id) }}">
                                    <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                        class="m-2 mask border border-2"></a>
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
                        <div class="col-6 align-self-center">
                            @if ($post->image)
                                <div class="card border-0">
                                    <img src="{{ asset('storage/images/' . $post->image) }}">
                                </div>
                            @endif
                        </div>

                        <p>{{ $post->body }}</p>

                        <div class="row">
                            <div class="col">
                                <!--コメント件数カウント-->
                                <i class="bi bi-chat">{{ $post->comments->count() }}件</i>
                                <!--いいねのカウント-->
                                <i class="bi bi-heart">{{ $post->likes->count() }}件</i>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    {!! $posts->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
