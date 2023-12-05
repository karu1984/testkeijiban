<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserprofController;
use App\Http\Controllers\UserprofileController;
use App\Http\Controllers\UserlikeController;
use App\Http\Controllers\FollowuserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/', [PostController::class,'index'])->name('top');
Route::get('/top', [PostController::class,'index'])->name('top');

// 新規記事投稿
Route::get('/top/create',[PostController::class,'create'])->name('top.create')->middleware(['auth'])->middleware('throttle:3, 1');
Route::post('/top/store',[PostController::class,'store'])->name('top.store')->middleware(['auth']);

Route::get('create', function () {return view('create');})->middleware(['auth']);

Route::get('/top/show/{post}',[PostController::class,'show'])->name('show');

Route::get('/top/{post}/edit',[PostController::class,'edit'])->name('edit')->middleware(['auth']);
Route::put('/top/{post}',[PostController::class,'update'])->name('update')->middleware(['auth']);

Route::delete('/top/{post}',[PostController::class,'destroy'])->name('post.destroy')->middleware(['auth']);
Route::delete('/userprofile/{post}',[PostController::class,'destroytwo'])->name('post.destroytwo')->middleware(['auth']);


//コメント投稿処理
Route::post('/top/{comment}/comments',[CommentController::class,'store'])->middleware(['auth'])->middleware('throttle:3, 1');
//コメント取消処理
Route::delete('/top/show/{comment}',[CommentController::class,'destroy'])->name('comment.destroy')->middleware(['auth']);

//いいねを付ける
Route::get('like/{post}',[LikeController::class,'like'])->name('like');
//いいねをはすず
Route::get('/unlike/{post}',[LikeController::class,'unlike'])->name('unlike');

//フォローを付ける
Route::get('userlike/{user}',[UserlikeController::class,'userlike'])->name('userlike');
//フォローをはすず
Route::get('/userunlike/{user}',[UserlikeController::class,'userunlike'])->name('userunlike');


//マイページ表示
Route::get('hyoji',[UserprofController::class,'hyoji'])->name('hyoji');

//ユーザプロフィールを表示
Route::get('userprofile', [UserprofileController::class,'index'])->name('userprofile')->middleware(['auth']);
//プロジェクト作成ページに遷移
Route::get('/userprofiletop/create',[UserprofileController::class,'create'])->name('userprofile.create');
//プロフィールを保存
Route::post('/userprofile/store',[UserprofileController::class,'store'])->name('userprofile.store');
//プロフィールを表示
Route::get('/userprofile/show/{user}',[UserprofileController::class,'show'])->name('userprofile.show');
//プロフィール編集ページに遷移
Route::get('/userprofile/{user}/edit',[UserprofileController::class,'edit'])->name('userprofile.edit');
//プロフィールを更新
Route::put('/userprofile/{user}',[UserprofileController::class,'update'])->name('userprofile.update');


//プロフィール物理削除
Route::delete('/userprofile/{user}',[UserprofileController::class,'destroy'])->name('userprofile.destroy');


//フォローしているユーザ一覧を表示
Route::get('users', [FollowuserController::class,'index'])->name('users')->middleware(['auth']);

Route::get('followed', [FollowuserController::class,'followed'])->name('followed')->middleware(['auth']);


//followを付ける
Route::get('follow/{user}',[FollowuserController::class,'follow'])->name('follow');
//followをはすず
Route::get('/unfollow/{user}',[FollowuserController::class,'unfollow'])->name('unfollow');


//検索
Route::get('search', [PostController::class,'search'])->name('post.search');


//フォローを付ける
//oute::get('userlike/{user}',[UserlikeController::class,'like'])->name('userlike');
//フォローをはすず
//Route::get('/userlike/{user}',[UsrelikeController::class,'unlike'])->name('userunlike');
// Route::post('/users/{user}/unfollow', [FollowuserController::class,'unfollow']);

//Route::post('/follow/{userId}', [ FollowuserController::class, 'store'])->name('follow');