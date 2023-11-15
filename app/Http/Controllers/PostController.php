<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Userprofile;
use App\Models\Comment;

class PostController extends Controller
{
    public function index(Userprofile $userprofile,Post $post)
    {
        
        $posts=Post::orderBy('created_at','desc')->paginate(3);
        $user=Auth::user();
        $userprofiles = Userprofile::all();
        
        return view('top',compact('user','posts','userprofiles'));
    }

    public function create()
    {
        
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' =>'required|max:255',
            'body' =>'required|max:255',
            'image'=>'image|max:1024'
        ]);

        $post = new Post;
        $post->title = $request->input(["title"]);
        $post->body = $request->input(["body"]);
        $post->user_id=auth()->user()->id;
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }
        $post->save();

        return redirect()->route('top');
    }
    public function show(Post $post)
    {
        return view('show',compact('post'));
    }

    public function edit(Post $post)
    {
        return view('edit',compact('post'));
    }

    public function update(Request $request,Post $post)
    {
        $request->validate([
            'title' =>'required',
            'body' =>'required',
           
        ]);
        $post->title = $request->input(["title"]);
        $post->body = $request->input(["body"]);
        $post->user_id=auth()->user()->id;
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }
        $post->save();

        return redirect()->route('top');
    }
    public function destroy(Post $post,Comment $comment)
    {
        $post->delete();
        $post->comments()->delete();
        return redirect()->route('top');
    }
}
