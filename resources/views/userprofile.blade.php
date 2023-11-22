@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本文 --}}
            <div class="col-7">
                {{-- 投稿削除アラート --}}
                @if ($message = Session::get('delete'))
                    <div class="alert alert-danger">{{ $message }}</div>
                @endif
                <h4 class="my-2 anim-box slidein is-animated">マイページ</h4>
                <!--自己紹介があれば表示-->

                <!--画像があれば表示-->
                <img src="{{ asset('storage/images/' . $user->image) }}" class="mask border border-2">
                @if (isset($user->introduction))
                    <div class="col ">
                        {{ $user->introduction }}
                        <br>
                        <br>

                        {{-- 事項紹介があれば編集するようのボタン --}}

                        <table>
                            <tr>
                                {{-- 編集ボタン --}}
                                <td><div class="raberu mx-2 px-5 my-1" style="width:auto;">
                                        <a class="nav-link" href="{{ route('userprofile.edit', $userprofile->id) }}">プロフィール編集</a>
                                        </div>
                                </td>
                                <td>
                                    {{-- 削除ボタン --}}

                                    {{-- <form action="{{ route('userprofile.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">削除</button>
                                    </form> --}}
                                </td>

                                {{-- フォローしてる人数 --}}
                                <td>
                                    <div class="raberu mx-2 my-1" style="width:auto;">
                                        <a class="nav-link" href="{{ route('users', $userprofile->id) }}">フォローしている人数:
                                            {{ $followusers->where('following_user_id', Auth::user()->id)->count() }}</a>
                                    </div>
                                </td>
                                {{-- フォローされている人数 --}}
                                <td>
                                    <div class="raberu mx-2  my-1" style="width:auto">
                                        <a class="nav-link" href="{{ route('followed', $userprofile->id) }}">フォローされている人数:
                                        {{ $followusers->where('followed_user_id', Auth::user()->id)->count() }}</a>
                                    </div>
                                </td>



                            </tr>
                        </table>

                    </div>

                    <!--自己紹介が登録されてなければ登録を促す-->
                @else
                    <a href="{{ route('userprofile.create') }}">自己紹介がありません。作成しましょう</a>
                @endif


                <div class="justify-content-center mt-auto py-4 mb-2 bg-body-secondary">投稿したポスト新着</div>


                @if (isset($user->id))
                    <!--投稿の表示-->
                    @foreach ($posts as $post)
                        <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                            {{ $post->user->name }}
                        <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
                        {{ $post->body }}

                        <form action="{{ route('post.destroytwo', $post->id) }}" method="POST" class="text-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light mx- " onclick='return confirm("削除しますか")'>
                                <i class="bi bi-trash3"></i></button>
                        </form>

                        <hr>
                    @endforeach
                    {!! $posts->links('pagination::bootstrap-5') !!}

                    <div class="justify-content-center mt-auto py-4 mb-2 bg-body-secondary">いいねポスト、いいね順</div>
                    <!--いいね投稿の表示-->
                    @foreach ($l_posts as $l_post)
                        @if (isset($l_post->post))
                            <p><a href="{{ route('show', $l_post->post) }}">{{ $l_post->post->title }}</a>
                                {{ $l_post->post->user->name }}
                            <div class="text-end"><span>{{ $l_post->post->created_at->diffForHumans() }}</span></div>
                            {{ $l_post->post->body }}
                            <hr>
                        @else
                            削除された投稿です。
                            <hr>
                        @endif
                    @endforeach
                    {!! $posts->links('pagination::bootstrap-5') !!}
                @endif
            </div>

            {{-- サイドバーパーツ、広告など --}}
            @include('sidepop')
        </div>
    </div>
@endsection
