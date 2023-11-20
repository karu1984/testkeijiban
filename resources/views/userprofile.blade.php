@extends('head')
@section('content')

    <div class="row justify-content-center">

        <div class="col-7">
            {{-- 投稿削除アラート --}}
            @if ($message = Session::get('delete'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <h4>マイページです</h4>
            <!--自己紹介があれば表示-->
            @if (isset($userprofile->id))
                <!--画像があれば表示-->
                <div class="col-2 m-2">
                    <img src="{{ asset('storage/images/' . $user->image) }}" class="mask border border-2">
                </div>
                {{-- class="img-fluid rounded-circle"> --}}
                <div class="col ">
                    {{ $userprofile->introduction }}
                    {{-- 事項紹介があれば編集するようのボタン --}}

                    <table>
                        <tr>
                            {{-- 編集ボタン --}}
                            <td><a href="{{ route('userprofile.edit', $userprofile->id) }}"><button
                                        class="btn btn-sm btn-success">編集</button></a>
                            </td>
                            <td>
                                {{-- 削除ボタン --}}
                                <form action="{{ route('userprofile.destroy', $userprofile->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick='return confirm("削除しますか")'>削除</button>
                                </form>
                            </td>
                            {{-- フォロー機能テストユーザ一覧 --}}
                            <td><a href="{{ route('users', $userprofile->id) }}"><button
                                        class="btn btn-sm btn-success">フォロー中のユーザ一覧</button></a>
                            </td>



                        </tr>
                    </table>

                </div>

                <!--自己紹介が登録されてなければ登録を促す-->
            @else
                <a href="{{ route('userprofile.create') }}">自己紹介がありません。作成しましょう</a>
            @endif


            <div class="justify-content-center mt-auto py-4 mb-2 bg-body-tertiary">投稿したポスト新着</div>


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
                        <button type="submit" class="btn btn-light mx- " onclick='return confirm("削除しますか")'><i
                                class="bi bi-trash3"></i></button>
                    </form>

                    <hr>
                @endforeach
                {!! $posts->links('pagination::bootstrap-5') !!}

                <div class="justify-content-center mt-auto py-4 mb-2 bg-body-tertiary">いいねポスト、いいね順</div>
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

    @endsection
