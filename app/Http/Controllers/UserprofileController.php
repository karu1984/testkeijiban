<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Auth;

class UserprofileController extends Controller
{
    public function index(Userprofile $userprofile)
    {
        $userprofile=Userprofile::where('user_id',Auth::user()->id)->first();
        $user=Auth::user();
        return view('userprofile',compact('user','userprofile'));
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
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $userprofile->image = $name;
        }
        $userprofile->save();

        return redirect()->route('top');
    }

    public function show(Userprofile $userprofile,User $user)
    {
        $userprofile=Userprofile::where('user_id',$user->id)->first();
      return view('userprofile.show',compact('userprofile','user'));
    }
    public function edit(Userprofile $userprofile)
    {
        return view('userprofile.edit',compact('userprofile'));
    }

    public function update(Request $request,Userprofile $userprofile)
    {
        $request->validate([
            'introduction' =>'required|max:255',
            'image'=>'image|max:1024'
        ]);

        $userprofile->introduction = $request->input(["introduction"]);
        $userprofile->user_id=auth()->user()->id;
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $userprofile->image = $name;
        }
        $userprofile->save();

        return redirect()->route('top');
    }

    public function destroy(Userprofile $userprofile)
    {
        $userprofile->delete();
        return redirect()->route('top');
    }
}
