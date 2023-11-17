@extends('head')
@section('content')
    <div class="container">
        <div class="row   justify-content-center">
            <div class="col-7 ">
                <h1 >新着記事一覧</h1>
                <div>
                    {{-- 投稿成功アラート --}}
                    @if($message = Session::get('success'))
                        <div class="alert alert-primary">{{$message}}</div>
                    @endif
                    {{-- 投稿編集アラート --}}
                    @if($message = Session::get('henkou'))
                        <div class="alert alert-success">{{$message}}</div>
                    @endif
                    {{-- 投稿削除アラート --}}
                    @if($message = Session::get('delete'))
                        <div class="alert alert-danger">{{$message}}</div>
                    @endif
                    </div>
                <div class="card p-2 ">
                    @foreach ($posts as $post)
                        <div class="row ">
                            <div class="col-2">
                                {{-- ユーザ画像表示 --}}
                                <a href="{{ route('userprofile.show', $post->user->id) }}">
                                    <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                        class="m-2 img-fluid rounded-circle  border border-1"></a>
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
                        <div class="col-7 align-self-center">
                            @if ($post->image)
                                    <section class="grayscale">
                                        <div class="grayscale-img">
                                            <a href="{{ route('show', $post) }}">
                                                <img src="{{ asset('storage/images/' . $post->image) }}" class="rounded-3">
                                            </a>
                                        </div>
                                    </section>
                            @endif
                            <p>{{ $post->body }}</p>




                        </div>



                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col">
                                <!--コメント件数カウント-->
                                <i class="bi bi-chat mx-2"></i>{{ $post->comments->count() }}
                                {{-- いいねのてすと --}}
                                @auth


                                    <td>
                                        @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                            <a href="{{ route('unlike', $post) }}">
                                                <i class="bi bi-heart-fill unlike-btn"></i></a><span class="likecount">
                                                    {{ $post->likes->count() }}</span>
                                            <!--ログインユーザがいいねしてなかった場合-->
                                        @else
                                            <a href="{{ route('like', $post) }}">
                                                <i class="bi bi-heart-fill like-btn"></i></a>
                                                <span>{{ $post->likes->count() }}</span>
                                        @endif
                                    </td>
                                @else
                                    <!--いいねのカウント-->
                                    <i class="bi bi-heart">{{ $post->likes->count() }}件</i>
                                @endauth
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
