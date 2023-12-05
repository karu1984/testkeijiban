<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Userprofile;
use App\Models\Followuser;
use Illuminate\Support\Facades\Auth;

class UserprofileController extends Controller
{
    public function index(Userprofile $userprofile,Post $post,User $user,Like $like)
    {
        //自身がいいねした投稿の一覧
        $l_posts = Like::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(3);
        //自身が投稿した投稿の一覧
        $posts = Post::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(3);
        //ログインユーザの情報
        $user=Auth::user();

        $followusers=Followuser::all();
    
        return view('userprofile',compact('user','posts','l_posts','followusers'));
    }

    public function create()
    {
        return view('userprofile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'introduction' =>'required|max:255',
            'image'=>'image|max:1024'
        ]);

        $userprofile = new Userprofile;
        
        $userprofile->user_id=auth()->user()->id;
        
        $userprofile->save();

        //ここからユーザーテーブルに保存する記述、画像のみ。
        $user=Auth::user();
        $user->introduction = $request->input(["introduction"]);
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $user->image = $name;    
        }
        $user->save();

        return redirect()->route('top');
    }

    public function show(User $user,Post $post)
    {
        $userprofile=Userprofile::where('user_id',$user->id)->first();
        $posts=Post::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(3);
      return view('userprofile.show',compact('userprofile','user','posts'));
    }

    
    public function edit(Userprofile $userprofile)
    {
        $user=Auth::user();
        return view('userprofile.edit',compact('userprofile','user'));
    }

    public function update(Request $request,Userprofile $userprofile,User $user)
    {
        $request->validate([
            'introduction' =>'required|max:255',
            'image'=>'image|max:1024'
        ]);

       
        // $userprofile->user_id=auth()->user()->id;
        
        // $userprofile->save();
        
        //ここからユーザーテーブルに保存する記述、画像のみ。
        $user=Auth::user();
        $user->introduction = $request->input(["introduction"]);
        if (request('image')){

            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $user->image = $name;
        }
        if (request('imagenone')){

            
            $user->image = 'デフォルト人影画像.png';
        }
        $user->save();
        
        return redirect()->route('userprofile');
    }

    public function destroy(Userprofile $userprofile)
    {
        $user=Auth::user();
        $user->introduction = '自己紹介がありません';
        // if (request('image')){

        //     $original = request()->file('image')->getClientOriginalName();
        //      // 日時追加　
        //     $name = date('Ymd_His').'_'.$original;
        //     request()->file('image')->move('storage/images', $name);
        //     $user->image = $name;
        // }
        $user->save();

       
        // $userprofile->delete();
        return redirect()->route('top');
    }
}
