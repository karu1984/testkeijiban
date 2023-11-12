@extends('head')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 mt-4">
            <h1>投稿編集画面</h1>

            <form action="{{route('update',$post)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="formgroup card mb-2">
                    <input type="text" name="title" placeholder="タイトルを入力" value="{{old('title',$post->title)}}">
                </div>
                <div class="formgroup">
                    <textarea name="body" rows="10">{{old('body',$post->body)}}</textarea>
                </div>
                @if($post->image)
                <div class="card">
                    (画像ファイル：{{$post->image}})
                    <img src="{{ asset('storage/images/'.$post->image)}}" class="mx-auto d-block" style="height:100px;">
                </div>
                @endif
                <div>
                    <input type="file" name="image">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">更新する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection