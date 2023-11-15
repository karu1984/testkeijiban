@extends('head')
@section('content')
<div class="row">
    <div class="col-6">
        <h1>
            ユーザプロフィール作成
        </h1>
        
        <form action="{{ route('userprofile.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="formgroup card mb-2">
                自己紹介を入力しましょう。
                <textarea name="introduction" id="" rows="10"></textarea>
            </div>
            <div>
                プロフィール写真を登録しましょう。<br>
                <input type="file" name="image">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">登録する</button>
                <a class="btn btn-success" href="{{ url('/top') }}">戻る</a>
            </div>
        </form>
    </div>
</div>

@endsection