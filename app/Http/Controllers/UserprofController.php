<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserprofController extends Controller
{
    public function userprof_edit(Userprof $userprof){
        return view('userprof');
    }
    public function userprof(Userprof $userprof){
        $userprof = New Userprof();
        $userprof->introduction = $request->input(["introduction"]);
        $userprof->user_id=auth()->user()->id;
        $userprof->followed_id= $request->input(["followed_id"]);
        if (request('image')){
            $original = request()->file('image')->getClientOriginalName();
             // 日時追加　
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $userprof->image = $name;
        }
        $userprof->save();
    }
}
