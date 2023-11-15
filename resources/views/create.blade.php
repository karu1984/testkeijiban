@extends('head')
@section('content')
    <div class="row">
        <div class="col-6">
            <h1>
                新規投稿作成
            </h1>

            <form action="{{ route('top.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="formgroup card mb-2">
                    <input type="text" name="title" placeholder="タイトルを入力">
                </div>
                <div class="formgroup card mb-2">
                    <textarea name="body" id="" rows="10"></textarea>
                </div>
                <div>
                    <input type="file" name="image">
                </div>
                <div>
                    <button type="submit">登録する</button>
                </div>

                <a class="btn btn-success" href="{{ url('/top') }}">戻る</a>

            </form>
        </div>
    </div>
@endsection
