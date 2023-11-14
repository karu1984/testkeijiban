<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    use HasFactory;
    protected $fillable = [
        'introduction',
        'user_id',
        'image',
    ];

    //ユーザモデルとのリレーション
    public function user(){
        return $this->hasMany('App\Models\User');
    } 


}