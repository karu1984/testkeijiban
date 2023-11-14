@extends('head')
@section('content')


    <h4>自己紹介表示ページです</h4>
    <!--自己紹介があれば表示-->
    @if (isset($userprofile->id))
    <a href="{{ route('userprofile.edit', $userprofile->id) }}"><button class="btn btn-primary">編集する</button></a>

    <form action="{{ route('userprofile.destroy', $userprofile->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか")'>削除</button>
    </form>
        {{ $userprofile->introduction }}
        <!--画像があれば表示-->
        @if ($userprofile->image)
            <div class="card border-0">
                <img src="{{ asset('storage/images/' . $userprofile->image) }}" class="mx-auto d-block" style="height:50px;">
            </div>
        @endif
    <!--自己紹介が登録されてなければ登録を促す-->
    @else
        <a href="{{ route('userprofile.create') }}">自己紹介がありません。作成しましょう</a>
    @endif
@endsection
