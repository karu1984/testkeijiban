@extends('head')
@section('content')
    <div class="container">
        <div class="row   justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-10 col-lg-7 phone-body">
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
                        <div class="flex-container">

                            {{-- ユーザ画像表示 --}}
                            {{-- 画像リンク分岐、ログインユーザならマイページに遷移 --}}
                            @auth
                                @if ($post->user->id == Auth::user()->id)
                                    <a href="{{ route('userprofile', $post->user->id) }}">
                                        <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                            class="m-2 mask phone-gazo border border-2"></a>

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

                            <div class="flex-container-b">
                                 {{-- 投稿タイトル --}}
                               
                                 <div class="flex-item flex-item-c d-flex">  &nbsp
                                <a class="blue-moji nav-link"
                                        href="{{ route('userprofile.show', $post->user->id) }}">{{ $post->user->name }}
                                        <span class="black-moji">{{ $post->created_at->diffForHumans() }}</span></a>
                                </div>

                                <div class="flex-item flex-item-b d-flex">                         
                                    <a class="blue-moji nav-link" href="{{ route('show', $post) }}">{{ $post->title }}</a> &nbsp
                                </div>
                            </div>
                        </div>




                        <!--画像があれば表示-->
                        <div class="d-flex justify-content-center">
                            @if ($post->image)
                                <section class="grayscale">
                                    <div class="grayscale-img">
                                        <a href="{{ route('show', $post) }}">
                                            <img src="{{ asset('storage/images/' . $post->image) }}" class="rounded-3">
                                        </a>
                                    </div>
                                </section>
                            @endif
                        </div>
                        {{-- 記事本文 --}}
                        <div>
                            <p>{{ nl2br($post->body) }}</p>
                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col ">
                                <!--コメント件数カウント-->
                                {{-- いいねのてすと --}}
                                <i class="bi bi-chat ms-5 me-1"></i><span>{{ $post->comments->count() }}</span>
                                @auth
                                    <td>
                                        @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                            <a href="{{ route('unlike', $post) }}">
                                                <i class="bi bi-heart-fill unlike-btn ms-5"></i></a><span class="likecount">
                                                {{ $post->likes->count() }}</span>
                                            <!--ログインユーザがいいねしてなかった場合-->
                                        @else
                                            <a href="{{ route('like', $post) }}">
                                                <i class="bi bi-heart-fill like-btn  ms-5"></i></a>
                                            <span>{{ $post->likes->count() }}</span>
                                        @endif
                                    </td>
                                @else
                                    <!--いいねのカウント-->
                                    <i class="bi bi-heart ms-5 me-1"></i><span>{{ $post->likes->count() }}</span>
                                @endauth
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    {!! $posts->links('pagination::bootstrap-5') !!}

                </div>
            </div>

            {{-- サイドバーパーツ、広告など --}}
            {{-- @include('sidepop') --}}

        </div>
    </div>
@endsection
