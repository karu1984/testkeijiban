@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7 mt-4 phone-body">
                <h1>投稿編集画面</h1>
                {{-- コメントの編集 --}}
                <form action="{{ route('update', $post) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="formgroup card mb-2">
                        <input type="text" name="title" placeholder="タイトルを入力" value="{{ old('title', $post->title) }}">
                    </div>
                    {{-- バリデーションエラーの表示 --}}
                    @error('title')
                        <span style="color:red;">タイトルを40文字以内で入力してください</span>
                    @enderror

                    <div class="formgroup card">
                        <textarea name="body" rows="10">{{ old('body', $post->body) }}</textarea>
                    </div>
                     {{-- バリデーションエラーの表示 --}}
                     @error('body')
                     <span style="color:red;">本文を255文字以内で入力してください</span>
                 @enderror
                    {{-- 画像があれば --}}
                    @if ($post->image)
                        <div class="card">
                            画像ファイル：{{ $post->image }}
                            <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto d-block mb-2"
                                style="height:100px;">
                        </div>
                    @endif
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

                    </div>
                    <div class="row justify-content-end">
                        <button type="submit" class="col-md-2 btn btn-primary m-1">更新</button>
                        <a type="button" class="col-md-2 btn btn-success m-1" href="{{ route('show',$post->id) }}">戻る</a>
                    </div>
                </form>
            </div>

            {{-- サイドバーパーツ、広告など --}}
            @include('sidepop')
        </div>
    </div>
@endsection
