<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ソフトデリート使うための親クラス
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ListingView;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
  


    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function post(){
    
        return $this->belongsTo('App\Models\Post');
    }
}
