@extends('head')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 mt-4">
            <h1>プロフ編集画面</h1>

            <form action="{{route('userprofile.update',$userprofile->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                
                <div class="formgroup card mb-2">
                    <textarea name="introduction" rows="10" >
                        {{old('introduction',$userprofile->introduction)}}
                    </textarea>
                </div>
    
                @if($userprofile->image)
                <div class="card">
                    (画像ファイル：{{$userprofile->image}})
                    <img src="{{ asset('storage/images/'.$userprofile->image)}}" class="mx-auto d-block" style="height:100px;">
                </div>
                @endif
                <div>
                    <input type="file" name="image">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">更新する</button>
                    <a class="btn btn-success" href="{{ url('/top') }}">戻る</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection