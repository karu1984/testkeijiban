@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class=col-7>
                <h1> 記事詳細画面</h1>
                <div class="card">
                    <div class="row">
                        <div class="col-2">
                            {{-- ユーザ画像表示 --}}
                            <a href="{{ route('userprofile.show', $post->user->id) }}">
                                <img src="{{ asset('storage/images/' . $post->user->image) }}"
                                    class="m-2 img-fluid rounded-circle border border-1"></a>
                        </div>
                        {{-- 投稿タイトル --}}

                        <div class="col mx-1 my-1">
                            <a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                        </div>
                        <div class="col text-end mx-1 my-1">
                            <a href="{{ route('userprofile.show', $post->user->id) }}">投稿者:{{ $post->user->name }}</a>
                            {{ $post->created_at->diffForHumans() }}
                        </div>

                    </div>




                    <!--画像があれば表示-->
                    @if ($post->image)
                        <div class="col-6 align-self-center">
                            <img src="{{ asset('storage/images/' . $post->image) }}" class="img-fluid rounded-3">
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-2 mx-4"></div>
                        <div class="col">
                        
                            {{-- 記事本文 --}}
                            <p>{{ $post->body }}</p>
                        </div>
                        <!--ログインしてれば表示-->
                        @auth
                            <div class="row"></div>
                            <div class="col-2"></div>
                            <div class="col mb-1">

                                <div class="btn-group" role="group">
                                    @if ($post->user_id == Auth::user()->id)
                                        <a href="{{ route('edit', $post->id) }}"><button class="btn btn-light mx-5"><i
                                                    class="bi bi-pencil-square "></i></button></a>

                                        {{-- 記事削除 --}}
                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light mx-5"
                                                onclick='return confirm("削除しますか")'><i class="bi bi-trash3"></i></button>

                                        </form>
                                    @endif
                                </div>
                                <!--ログインユーザすでにいいねしてる場合-->
                                <td>
                                    @if ($post->likes()->where('user_id', Auth::user()->id)->count() == 1)
                                        <a href="{{ route('unlike', $post) }}">
                                            <i class="bi bi-heart-fill unlike-btn"></i></a>
                                            <span class="likecount">{{ $post->likes->count() }}</span>
                                        <!--ログインユーザがいいねしてなかった場合-->
                                    @else
                                        <a href="{{ route('like', $post) }}">
                                            <i class="bi bi-heart-fill like-btn"></i></a>
                                            <span >{{ $post->likes->count() }}</span>
                                    @endif
                                </td>
                                </tr>
                                </table>

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
                        <i class="bi bi-heart-fill like-btn">{{ $post->likes->count() }}</i>
                        <hr>
                    @endauth

                    <!--既存のコメント表示-->
                    @foreach ($post->comments->sortByDesc('created_at') as $comment)
                        {{-- ユーザ画像表示 --}}
                        <div class="col-2">
                            <a href="{{ route('userprofile.show', $comment->user->id) }}">
                                <img src="{{ asset('storage/images/' . $comment->user->image) }}"
                                    class="m-2 img-fluid rounded-circle border border-1"></a>
                        </div>
                        {{ $comment->comment }}
                        <a href="{{ route('userprofile.show', $post->user->id) }}">
                            投稿者:{{ $comment->user->name }}</a>
                        {{ $comment->created_at->diffForHumans() }}
                        <!--コメント削除-->
                        @if ($comment->user->id == Auth::id())
                            <div class="text-end">
                                <form action="/top/show/{{ $comment->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn  btn-sm btn-light mx-3"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        @endif
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
