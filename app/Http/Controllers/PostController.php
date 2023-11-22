<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Userprofile;
use App\Models\Comment;

class PostController extends Controller
{
    public function index(Userprofile $userprofile,Post $post)
    {
        
        $posts=Post::orderBy('created_at','desc')->paginate(3);
        $user=Auth::user();
        $userprofiles = Userprofile::all();
        if(isset(Auth::user()->id)){
        $userprofile=Userprofile::where('user_id',Auth::user()->id)->first();
        }
        
        return view('top',compact('user','posts','userprofiles','userprofile'));
    }

    public function create(User $user)
    {
        $user=Auth::user();
        if(isset(Auth::user()->id)){
            $userprofile=Userprofile::where('user_id',Auth::user()->id)->first();
            }
        return view('create',compact('user','userprofile'));
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

        return redirect()->route('top')->with('success','記事を投稿しました');
    }
    public function show(Post $post,User $user,Userprofile $userprofile)
    {
        $userprofile=Userprofile::where('user_id',Auth::user())->first();
        $user=Auth::user();
        
        return view('show',compact('user','post','userprofile'));
    }

    public function edit(Post $post)
    {
        return view('edit',compact('post'));
    }

    public function update(Request $request,Post $post)
    {
        $request->validate([
            'title' =>'required|max:255',
            'body' =>'required|max:255',
           
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

        return redirect()->route('top')->with('henkou','投稿を編集しました');
    }

    public function destroy(Post $post,Comment $comment)
    {
        $post->delete();
        $post->comments()->delete();
       
        $like = Like::where('post_id', $post->id)->delete();
      
        // return back()->with('delete','投稿を削除しました');
      
        return redirect()->route('top')->with('delete','投稿を削除しました');
        
    }


    public function destroytwo(Post $post,Comment $comment,Userprofile $userprofile)
    {
        $post->delete();
        $post->comments()->delete();
       
        $like = Like::where('post_id', $post->id)->delete();
      
        return back()->with('delete','投稿を削除しました');
      
        // return redirect()->route('top')->with('delete','投稿を削除しました');
        
    }

    public function search(Request $request)
    {      
        $search = $request->input('keyword');//リクエストからkeywordパラメーターの値を取得し、$search変数に代入、ユーザーが検索フォームに入力したキーワードが格納される
        $query = Post::query(); //モデルに対してクエリビルダを作成し、$query変数に代入してこのクエリビルダを使ってデータベースクエリを構築

        if (!empty($search)) { //$search変数が空でない時、つまりユーザーがキーワードを入力した場合に、検索条件を追加
            $query->where('title', 'LIKE', "%{$search}%");//textカラムがユーザーの入力したキーワードを部分一致で含む場合に検索条件を追加します。% はワイルドカード文字で、任意の文字列を表す
        } 

$user=Auth::user();
        $posts = $query->orderBy('id','desc')->paginate(10);//クエリビルダに対して、id カラムで降順に並び替えを行い、ページネーションを適用し取得するデータは1ページあたり10件
        return view('search', ['posts' => $posts, 'search' => $search,'user' =>$user]);//welcome ビューにデータを渡して、ビューを表示、$posts変数には検索結果が格納され、$search 変数にはユーザーが入力したキーワードが格納。ビュー内でこれらの変数を使用して結果を表示
    }

}
