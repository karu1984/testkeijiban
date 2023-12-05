@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')


            {{-- コンテンツ本体 --}}
            <div class="phone-body col-7">
                <h1 class="fs-4 mt-2 anim-box slidein is-animated">記事詳細画面</h1>
                <div class="card p-2">
                    {{-- 投稿ヘッド部分行、投稿者画像、名前、投稿日時 --}}
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

                        {{-- 投稿タイトル --}}
                        <div class="flex-container-b">

                            {{-- 投稿者、投稿日時 --}}
                            <div class="flex-item flex-item-c d-flex"> &nbsp
                                <a class="blue-moji nav-link"
                                    href="{{ route('userprofile.show', $post->user->id) }}">{{ $post->user->name }}
                                    <span class="black-moji"> {{ $post->created_at->diffForHumans() }}</a><span>
                            </div>
                            <div class="me-auto">
                                {{ $post->title }}
                            </div>
                        </div>
                    </div>


                    <!--投稿に画像があれば表示-->
                    <div class="align-self-center">
                        @if ($post->image)
                            <div class="align-self-center">
                                <img src="{{ asset('storage/images/' . $post->image) }}" class="post-img rounded-3">
                            </div>
                        @endif
                    </div>

                    {{-- 記事本文 --}}



                    <p>{{ nl2br($post->body) }}</p>


                    <!--ログインしてれば表示-->
                    @auth

                        {{-- 編集、削除、いいねボタン類 --}}
                        <div class="col mb-1">
                            <div class="btn-group" role="group" style="margin-left: 10%">
                                {{-- 記事投稿者がログインユーザならば表示 --}}
                                @if ($post->user_id == Auth::user()->id)
                                    {{-- 記事編集 --}}
                                    <a href="{{ route('edit', $post->id) }}"><button class="btn btn-light"><i
                                                class="bi bi-pencil-square item"></i></button></a>
                                    {{-- 記事削除 --}}
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light ms-5" onclick='return confirm("削除しますか")'><i
                                                class="bi bi-trash3"></i></button>
                                    </form>
                                @endif
                            </div>
                            <!--ログインユーザすでにいいねしてる場合-->

                            @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                <a href="{{ route('unlike', $post) }}">
                                    <i class="bi bi-heart-fill unlike-btn ms-5"></i></a>
                                <span class="likecount">{{ $post->likes->count() }}</span>
                                <!--ログインユーザがいいねしてなかった場合-->
                            @else
                                <a href="{{ route('like', $post) }}">
                                    <i class="bi bi-heart-fill like-btn ms-5"></i></a>
                                <span>{{ $post->likes->count() }}</span>
                            @endif

                        </div>
                    </div>
                    <!--ログインユーザのみ、新規コメントの投稿-->

                    <form action="/top/{{ $post->id }}/comments" method="post">
                        @csrf
                        <input value="{{ $post->id }}" type="hidden" name="post_id">
                        <div class="formgroup card border border-0 mb-2">
                            <textarea class="mb-2" name="comment" rows="3"></textarea>
                            <div class="row justify-content-end">

                                <input class="col col-sm-2 btn btn-success btn-sm mx-2" type="submit" value="送信">

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
                        <i class="bi bi-heart-fill like-btn "></i><span>{{ $post->likes->count() }}</span>
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

                        <a class="blue-moji nav-link" href="{{ route('userprofile.show', $comment->user->id) }}">
                            {{ $comment->user->name }}
                            <span class="black-moji">{{ $comment->created_at->diffForHumans() }}<span></a>

                
                    </div>
                    {{-- 改行表示のためのnl2br --}}
                    <div class="mx-2" id="word-break">
                        {!! nl2br(e($comment->comment)) !!}
                    </div>
                    <!--コメント削除-->
                    @if ($comment->user->id == Auth::id())
                        <div class="text-end">
                            <form action="/top/show/{{ $comment->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn  btn-sm btn-light mx-3" onClick="delete_alert(event);return false;"><i
                                        class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    @endif
                    <hr>
                @endforeach
                {{ $post->comments->links('pagination::bootstrap-5') }}

            </div>
        </div>

        {{-- サイドバーパーツ、広告など --}}
        {{-- @include('sidepop') --}}
    </div>
@endsection
