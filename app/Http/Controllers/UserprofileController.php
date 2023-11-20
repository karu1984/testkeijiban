<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Auth;

class UserprofileController extends Controller
{
    public function index(Userprofile $userprofile,Post $post,User $user,Like $like)
    {
        //自身がいいねした投稿の一覧
        $l_posts = Like::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(3);
        //自身が投稿した投稿の一覧
        $posts = Post::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(3);
        //自身のプロフィール
        $userprofile=Userprofile::where('user_id',Auth::user()->id)->first();
        //ログインユーザの情報
        $user=Auth::user();
        return view('userprofile',compact('user','userprofile','posts','l_posts'));
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
        $userprofile->introduction = $request->input(["introduction"]);
        $userprofile->user_id=auth()->user()->id;
        
        $userprofile->save();

        //ここからユーザーテーブルに保存する記述、画像のみ。
        $user=Auth::user();
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

    public function show(Userprofile $userprofile,User $user,Post $post)
    {
        $userprofile=Userprofile::where('user_id',$user->id)->first();
        $posts=Post::where('user_id',$user->id)->orderBy('created_at','DESC')->get();
      return view('userprofile.show',compact('userprofile','user','posts'));
    }
    public function edit(Userprofile $userprofile)
    {
        return view('userprofile.edit',compact('userprofile'));
    }

    public function update(Request $request,Userprofile $userprofile,User $user)
    {
        $request->validate([
            'introduction' =>'required|max:255',
            'image'=>'image|max:1024'
        ]);

        $userprofile->introduction = $request->input(["introduction"]);
        $userprofile->user_id=auth()->user()->id;
        
        $userprofile->save();
        
        //ここからユーザーテーブルに保存する記述、画像のみ。
        $user=Auth::user();
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

    public function destroy(Userprofile $userprofile)
    {
        $userprofile->delete();
        return redirect()->route('top');
    }
}
