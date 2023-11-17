{{-- フォロー中のユーザ一覧 --}}

@extends('head')
@section('content')
    <div class="col-7">
        <div class="row">
            @foreach ($users as $user)
                <div>
                    <div class="col-1">
                        {{-- ユーザ画像表示 --}}
                        <a href="{{ route('userprofile.show', $user->id) }}">
                            <img src="{{ asset('storage/images/' . $user->image) }}" class="m-2 img-fluid rounded-circle"></a>
                    </div>
                    <div>{{ $user->name }}</div>
                    {{-- <div>{{$user->userprofile->introduction}}</div> --}}
                    <div class="text-end">
                        <a href="{{ route('unfollow', $user) }}" class="btn btn-danger btn-sm">
                            フォローを外す
                        </a>
                    </div>
                    <hr>
            @endforeach
        </div>
    </div>
@endsection
