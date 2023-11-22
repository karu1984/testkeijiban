<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Followuser;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Auth;

class FollowuserController extends Controller
{
    //フォローしているユーザーを表示
    //フォローされているユーザーを表示
    public function index(User $user,Followuser $followuser,Userprofile $userprofile)
    {
        $followusers=Followuser::where('following_user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        $posts = Post::whereIn('user_id', $followusers->pluck('followed_user_id'))->get();
        $users = User::whereIn('id', $followusers->pluck('followed_user_id'))->orderBy('created_at','desc')->get();
      


        return view('user/index',compact('users'));
    }

    public function followed(User $user,Followuser $followuser,Userprofile $userprofile)
    {
        $followedusers=Followuser::where('followed_user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        $users = User::whereIn('id', $followedusers->pluck('following_user_id'))->orderBy('created_at','desc')->get();
      


        return view('user/followed',compact('users'));
    }

    
    // public function index(User $user,Followuser $followuser,Userprofile $userprofile)
    // {
    //     $followusers=Followuser::where('following_user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
    //     $posts = Post::whereIn('user_id', $followusers->pluck('followed_user_id'))->get();
    //     $users = User::whereIn('id', $followusers->pluck('followed_user_id'))->orderBy('created_at','desc')->get();
    //     // $users = User::orderBy('created_at','desc')->get();
    //     return view('user/index',compact('users','followusers','posts'));
    // }






   //フォローをつける
   public function follow(User $user){
    $followuser = New Followuser();
    $followuser->followed_user_id =$user->id;
    $followuser->following_user_id = Auth::user()->id;
    $followuser->save();        
    return back();
}
//フォローを消す
public function  unfollow(User $user){
    $following_user = Auth::user()->id;
    $followuser = Followuser::where('followed_user_id', $user->id)->where('following_user_id', $following_user)->first();
    var_dump($followuser);
    $followuser->delete();
    return back();
}
}
