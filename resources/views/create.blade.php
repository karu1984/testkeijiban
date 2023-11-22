@extends('head')
@section('content')
    <div class="container">
        <div class="row   justify-content-center">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7">
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
                        <span style="color:red;">タイトルを255文字以内で入力してください</span>
                    @enderror

                    <div class="formgroup card mb-2">
                        <textarea name="body" id="" rows="7">{{ old('body') }}</textarea>
                    </div>
                    {{-- バリデーションエラーの表示 --}}
                    @error('body')
                        <span style="color:red;">本文を255文字以内で入力してください</span>
                    @enderror
                    <div>
                      
                            <input type="file" name="image" >
                      
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success my-1" type="submit">登録する</button>
                        <a class="btn btn-secondary my-1" href="{{ url('/top') }}">戻る</a>
                    </div>
                </form>
            </div>

             {{-- サイドバーパーツ、広告など --}}
             @include('sidepop')
        </div>
    </div>
@endsection
