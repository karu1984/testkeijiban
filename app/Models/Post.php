<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ソフトデリート使うための親クラス
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    //ソフトデリート使うための宣言
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    //いいね機能
    public function Likes(){
        return $this->hasMany('App\Models\Like');
    }
}
