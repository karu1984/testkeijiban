<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ソフトデリート使うための親クラス
use Illuminate\Database\Eloquent\SoftDeletes;

class Userprofile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'introduction',
        'user_id',
        'image',
    ];

    //ユーザモデルとのリレーション
    public function user(){
        return $this->hasMany('App\Models\User');
    } 
    public function posts(){
        return $this->hasMany('App\Models\Post');
    } 

}
