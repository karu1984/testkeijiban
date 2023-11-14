<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserprofController;
use App\Http\Controllers\UserprofileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('top', [PostController::class,'index'])->name('top');
Route::get('/top/create',[PostController::class,'create'])->name('top.create');
Route::post('/top/store',[PostController::class,'store'])->name('top.store');

Route::get('create', function () {return view('create');});

Route::get('/top/show/{post}',[PostController::class,'show'])->name('show');

Route::get('/top/{post}/edit',[PostController::class,'edit'])->name('edit');
Route::put('/top/{post}',[PostController::class,'update'])->name('update');

Route::delete('/top/{post}',[PostController::class,'destroy'])->name('post.destroy');

//コメント投稿処理
Route::post('/top/{comment}/comments',[CommentController::class,'store']);
//コメント取消処理
Route::delete('/top/show/{comment}',[CommentController::class,'destroy'])->name('comment.destroy');

//いいねを付ける
Route::get('like/{post}',[LikeController::class,'like'])->name('like');
//いいねをはすず
Route::get('/unlike/{post}',[LikeController::class,'unlike'])->name('unlike');

//マイページ表示
Route::get('hyoji',[UserprofController::class,'hyoji'])->name('hyoji');

//ユーザプロフィールを表示
Route::get('userprofile', [UserprofileController::class,'index'])->name('userprofile');
//プロジェクト作成ページに遷移
Route::get('/userprofiletop/create',[UserprofileController::class,'create'])->name('userprofile.create');
//プロフィールを保存
Route::post('/userprofile/store',[UserprofileController::class,'store'])->name('userprofile.store');
//プロフィールを表示
Route::get('/userprofile/show/{user}',[UserprofileController::class,'show'])->name('userprofile.show');
//プロフィール編集ページに遷移
Route::get('/userprofile/{userprofile}/edit',[UserprofileController::class,'edit'])->name('userprofile.edit');
//プロフィールを更新
Route::put('/userprofile/{userprofile}',[UserprofileController::class,'update'])->name('userprofile.update');
//プロフィール物理削除
Route::delete('/userprofile/{userprofile}',[UserprofileController::class,'destroy'])->name('userprofile.destroy');

//フォローを付ける
Route::get('userlike/{user}',[UserlikeController::class,'like'])->name('userlike');
//フォローをはすず
Route::get('/userlike/{user}',[UsrelikeController::class,'unlike'])->name('userunlike');