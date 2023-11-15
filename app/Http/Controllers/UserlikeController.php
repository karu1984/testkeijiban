<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use App\Models\Userlike;
use Illuminate\Support\Facades\Auth;


class UserlikeController extends Controller
{
   //いいねをつける
   public function userlike(User $user){
    $userlike = New Userlike();
    $userlike->fowolling_id =$user->id;
    $userlike->user_id = Auth::user()->id;
    $userlike->save();        
    return back();
}
// //いいねを消す
// // public function userunlike(User $user){
// //     //英語あってるか不明フォローしてるほうのユーザ
// //     $followed_user = Auth::user()->id;
// //     $userlike = Userlike::where('following_id', $user->id)->where('user_id', $followed_user)->first();
// //     $userlike->delete();
// //     return back();
// }
}
