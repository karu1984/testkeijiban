<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;

class UserprofController extends Controller
{
    //public function hyoji(Post $post,User $user){
    //    $posts=Post::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(2);
    //    return view('hyoji',compact('posts'));
    //}

    public function hyoji(Post $post,User $user,Like $like){
        $l_posts = Like::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        $posts = Post::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(2);
        return view('hyoji',compact('posts','l_posts'));
    }

    
}
