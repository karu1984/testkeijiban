@extends('head')
@section('content')


    <h4>マイページです</h4>
    <!--自己紹介があれば表示-->
    @if (isset($userprofile->id))
        <div class="row">
            <!--画像があれば表示-->
            <div class="col-2 m-2">
                    <img src="{{ asset('storage/images/' . $user->image) }}" class="img-fluid rounded-circle">
            </div>
            <div class="col">
                {{ $userprofile->introduction }}
                <table>
                    <tr>
                        <td><a href="{{ route('userprofile.edit', $userprofile->id) }}"><button
                                    class="btn btn-sm btn-success">編集</button></a></td>

                        <td>
                            <form action="{{ route('userprofile.destroy', $userprofile->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick='return confirm("削除しますか")'>削除</button>
                            </form>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <!--自己紹介が登録されてなければ登録を促す-->
    @else
        <a href="{{ route('userprofile.create') }}">自己紹介がありません。作成しましょう</a>
    @endif

    <div class="justify-content-center mt-auto py-0 mb-2 bg-body-tertiary">投稿したポスト新着</div>


    @if (isset($user->id))
        <!--投稿の表示-->
        @foreach ($posts as $post)
            <p><a href="{{ route('show', $post) }}">{{ $post->title }}</a>
                {{ $post->user->name }}
            <div class="text-end"><span>{{ $post->created_at->diffForHumans() }}</span></div>
            {{ $post->body }}

            <hr>
        @endforeach
        {!! $posts->links('pagination::bootstrap-5') !!}

        <div class="justify-content-center mt-auto py-0 mb-2 bg-body-tertiary">いいねポスト、いいね順</div>
        <!--投稿の表示-->
        @foreach ($l_posts as $l_post)
            <p><a href="{{ route('show', $post) }}">{{ $l_post->post->title }}</a>
                {{ $l_post->post->user->name }}
            <div class="text-end"><span>{{ $l_post->post->created_at->diffForHumans() }}</span></div>
            {{ $l_post->post->body }}
            <hr>
        @endforeach
    @endif




@endsection
