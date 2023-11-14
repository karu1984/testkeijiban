@extends('head')
@section('content')


    <h4>投稿したユーザのプロフィールページです</h4>
    


    <!--自己紹介があれば表示-->
    @if (isset($userprofile->id)) 
        ユーザID:{{ $user->id }}<br>
        ユーザ氏名:{{ $user->name}}<br>
        ユーザ自己紹介:{{ $userprofile->introduction }}<br>
        <!--画像があれば表示-->
        @if ($userprofile->image)
            <div class="card border-0">
                <img src="{{ asset('storage/images/' . $userprofile->image) }}" class="mx-auto d-block" style="height:50px;">
            </div>
        @endif 
    <!--自己紹介が登録されてなければ表示-->
     @else
    自己紹介がありません
    @endif 
@endsection
