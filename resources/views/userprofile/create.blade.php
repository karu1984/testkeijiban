@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7">
                <h1>
                    ユーザプロフィール作成
                </h1>

                <form action="{{ route('userprofile.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="formgroup card mb-2">
                        自己紹介を入力しましょう。
                        <textarea name="introduction" id="" rows="10"></textarea>
                    </div>
                    <div>
                        プロフィール写真を登録しましょう。<br>
                        <label class="btn btn-sm btn-danger my-1">
                            <input type="file" name="image" style="display: none;">画像を選択</label>

                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">登録する</button>
                        <a class="btn btn-success" href="{{ url('/top') }}">戻る</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- サイドバーパーツ、広告など --}}
        @include('sidepop')
    </div>
@endsection
