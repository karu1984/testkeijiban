@extends('head')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 mt-4">
                <h1>プロフ編集画面</h1>

                <form action="{{ route('userprofile.update', $userprofile->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="formgroup card mb-2">
                        <textarea name="introduction" rows="10">
                        {{ old('introduction', $userprofile->introduction) }}
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
                    {{-- 画像選択ボタン、「ファイルを選択してください」を消してます。 --}}
                    <div>
                        <label class="btn btn-sm btn-danger my-1">
                            <input type="file" name="image" style="display: none;">画像を選択</label>
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
