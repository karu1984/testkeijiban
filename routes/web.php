<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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