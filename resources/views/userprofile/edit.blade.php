@extends('head')
@section('content')
    <div class="container">
        <div class="row ">

            {{-- サイドバーパーツ自己紹介など --}}
            @include('sidebar')

            {{-- コンテンツ本体 --}}
            <div class="col-7 phone-body">
                <h1>プロフ編集画面</h1>

                <form action="{{ route('userprofile.update', $user->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card mb-2">
                        <textarea name="introduction" rows="10">
                        {{ old('introduction', $user->introduction) }}
                        </textarea>
                    </div>
                    {{-- 画像があれば --}}
                    @if (auth()->user()->image)
                        <div class="card">
                            画像ファイル名:{{ auth()->user()->image }}
                            <img src="{{ asset('storage/images/' . auth()->user()->image) }}" class="mx-auto my-1" style="height:100px;">
                        </div>
                    @endif
                    <div>
                        <input type="file" accept='image/*' name="image" onchange="previewImage(this);">
                        <br>
                        プレビュー:<br>
                        <div class="text-center">
                        <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                            class="image-100">
                        </div>
                        @error('image')
                        <span style="color:red;">画像ファイルを選択してください</span>
                    @enderror
                    </div>
                    <div class="justify-content-end d-flex">
                        <div>
                            <button type="submit" class="m-1 btn btn-primary">更新する</button>
                            <a class="m-1 btn btn-success"  onClick="history.back();">戻る</a>
                        </div>
                </form>


                <form class="m-1" action="{{ route('userprofile.update', $user->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input name="introduction" type="hidden" value="自己紹介がありません">
                    <input name="imagenone" type="hidden" value="imagenone">
                    <button type="submit" class="btn btn-danger" onClick="delete_alert(event);return false;">削除する</button>


                </form>
            </div>
        </div>

        {{-- サイドバーパーツ、広告など --}}
        @include('sidepop')

    </div>
    </div>
@endsection
