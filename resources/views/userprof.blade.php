@extends('head')
@section('content')
<div class="col-6">
    <h1>
        プロフィール作成
    </h1>
    
    <form action="{{url('top')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="formgroup card mb-2">
            <input type="text" name="introduction" placeholder="自己紹介を入力">
        </div>
        <div>
            <input type="file" name="image">
        </div>
        <div>
            <button type="submit">登録する</button>
        </div>
    </form>
</div>

@endsection