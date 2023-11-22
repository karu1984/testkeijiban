@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7 mt-4">
                <h1>プロフ編集画面</h1>

                <form action="{{ route('userprofile.update', $userprofile->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="formgroup card mb-2 ">
                        <textarea name="introduction" rows="10">
                        {{ old('introduction', $user->introduction) }}
                        </textarea>
                    </div>
                    {{-- 画像があれば --}}
                    @if (auth()->user()->image)
                        <div class="card">
                            画像ファイル名:{{ auth()->user()->image }}
                            <img src="{{ asset('storage/images/' . auth()->user()->image) }}" class="mx-auto"
                                style="height:100px;">
                        </div>
                    @endif
                    <div>
                        <input class="my-1" type="file" name="image">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">更新する</button>
                        <a class="btn btn-success" href="{{ url('/top') }}">戻る</a>
                    </div>
                </form>

                <form class="my-1" action="{{ route('userprofile.update', $userprofile->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input name="introduction" type="hidden" value="自己紹介がありません">
                    <input name="imagenone" type="hidden" value="imagenone">
                    <button type="submit" class="btn btn-danger">削除する</button>


                </form>
            </div>

            {{-- サイドバーパーツ、広告など --}}
            @include('sidepop')

        </div>
    </div>
@endsection
