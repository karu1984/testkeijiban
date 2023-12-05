@extends('head')
@section('content')
    <div class="container">
        <div class="row   justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7 phone-body">
                <h1>
                    新規投稿作成
                </h1>

                <form action="{{ route('top.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="formgroup card mb-1">
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="タイトルを入力">
                    </div>
                    {{-- バリデーションエラーの表示 --}}
                    @error('title')
                        <span style="color:red;">タイトルを40文字以内で入力してください</span>
                    @enderror

                    <div class="formgroup card mb-2">
                        <textarea name="body" id="" rows="7">{{ old('body') }}</textarea>
                    </div>
                    {{-- バリデーションエラーの表示 --}}
                    @error('body')
                        <span style="color:red;">本文を255文字以内で入力してください</span>
                    @enderror
                    <div>

                        <input type="file" accept='image/*' name="image" onchange="previewImage(this);">

                        <br>
                        プレビュー:<br>
                        <div class="text-center">
                            <img id="preview"
                                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                class="image-100">
                        </div>
                        @error('image')
                            <span style="color:red;">画像ファイルを選択してください</span>
                        @enderror



                        <div class="row justify-content-end">

                            <button class="col-md-2 btn btn-success ms-2 my-1" type="submit">投稿</button>

                            <a class="col-md-2 btn btn-secondary ms-2 " href="{{ url('/top') }}">戻る</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- サイドバーパーツ、広告など --}}
        @include('sidepop')
    </div>
@endsection
