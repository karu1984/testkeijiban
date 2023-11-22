{{-- フォロー中のユーザ一覧 --}}

@extends('head')
@section('content')
    <div class="row   justify-content-center">

        {{-- サイドバーパーツ自己紹介など --}}
        @include('sidebar')

        {{-- コンテンツ本体 --}}
        <div class="col-7">
            <h4 class="my-2 anim-box slidein is-animated">フォローされているユーザー</h4>
            @foreach ($users as $user)
                {{-- ユーザ画像表示 --}}
                <a href="{{ route('userprofile.show', $user->id) }}">
                    <img src="{{ asset('storage/images/' . $user->image) }}" class="m-2 mask"></a>

                {{ $user->name }}
                <div class="text-end">
                    <a href="#" class="btn btn-success btn-sm">
                        フォローされています
                    </a>
                </div>
                <hr>
            @endforeach
           
        </div>

         {{-- サイドバーパーツ、広告など --}}
         @include('sidepop')
    </div>
@endsection
