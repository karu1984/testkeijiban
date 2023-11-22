@extends('head')
@section('content')
    <div class="container">
        <div class="row   justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7">
                <h1 class="fs-4 mt-2 anim-box slidein is-animated">新着記事一覧</h1>
                <div>
                    {{-- 投稿成功アラート --}}
                    @if ($message = Session::get('success'))
                        <div class="alert alert-primary">{{ $message }}</div>
                    @endif
                    {{-- 投稿編集アラート --}}
                    @if ($message = Session::get('henkou'))
                        <div class="alert alert-success">{{ $message }}</div>
                    @endif
                    {{-- 投稿削除アラート --}}
                    @if ($message = Session::get('delete'))
                        <div class="alert alert-danger">{{ $message }}</div>
                    @endif
                </div>
                <div class="card p-2 ">
                    @foreach ($posts as $post)
                        <div class="row ">
                            <div class="col-2">
                                {{-- ユーザ画像表示 --}}

                                {{-- 画像リンク分岐、ログインユーザならマイページに遷移 --}}
                                @auth


                                    @if ($post->user->id == Auth::user()->id)
                                        <a href="{{ route('userprofile', $post->user->id) }}">
                                            <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                                class="m-2 mask border border-2"></a>

                                        {{-- 画像リンク分岐、ログインユーザでないなら投稿ユーザのページに遷移 --}}
                                    @else
                                        <a href="{{ route('userprofile.show', $post->user->id) }}">
                                            <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                                class="m-2 mask border border-2"></a>
                                    @endif

                                @endauth
                                {{-- ログインしてないならすべて投稿ユーザのページに遷移 --}}
                                @if (!Auth::user())
                                    <a href="{{ route('userprofile.show', $post->user->id) }}">
                                        <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                            class="m-2 mask border border-2"></a>
                                @endif


                            </div>
                            {{-- 投稿タイトル --}}
                            <div class="col">
                                <a class="nav-link" style="color: blue;"
                                    href="{{ route('show', $post) }}">{{ $post->title }}</a>
                            </div>
                            <div class="col text-end  mx-1 my-1 ">
                                <a href="{{ route('userprofile.show', $post->user->id) }}">{{ $post->user->name }}</a>
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <!--画像があれば表示-->
                        <div class="align-self-center">
                            @if ($post->image)
                                <section class="grayscale align-self-center">
                                    <div class="grayscale-img align-self-center">
                                        <a href="{{ route('show', $post) }}">
                                            <img src="{{ asset('storage/images/' . $post->image) }}"
                                                class=" align-self-center rounded-3">
                                        </a>
                                    </div>
                                </section>
                            @endif
                            <p>{!! nl2br($post->body) !!}</p>
                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col ">
                                <!--コメント件数カウント-->
                                {{-- いいねのてすと --}}
                                <i class="bi bi-chat mx-5">{{ $post->comments->count() }}</i>
                                @auth
                                    <td>
                                        @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                            <a href="{{ route('unlike', $post) }}">
                                                <i class="bi bi-heart-fill unlike-btn"></i></a><span class="likecount">
                                                {{ $post->likes->count() }}</span>
                                            <!--ログインユーザがいいねしてなかった場合-->
                                        @else
                                            <a href="{{ route('like', $post) }}">
                                                <i class="bi bi-heart-fill like-btn  ml-5"></i></a>
                                            <span>{{ $post->likes->count() }}</span>
                                        @endif
                                    </td>
                                @else
                                    <!--いいねのカウント-->
                                    <i class="bi bi-heart mx-5">{{ $post->likes->count() }}</i>
                                @endauth
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    {!! $posts->links('pagination::bootstrap-5') !!}
                </div>
            </div>

            {{-- サイドバーパーツ、広告など --}}
            @include('sidepop')

        </div>
    </div>
@endsection
