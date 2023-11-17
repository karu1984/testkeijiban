<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followuser extends Model
{
    use HasFactory;

    public function users()
    {
    return $this->belongsToMany('App\Models\User','followusers','followed_user_id','following_user_id');
    }
}

