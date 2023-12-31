<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    //ポストモデル
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
    //コメントモデル
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    //いいね機能
    public function Likes(){
        return $this->hasMany('App\Models\Like');
    }

    // フォロワー→フォロー
    public function followusers()
    {
        //多対多のリレーション、モデル指定、モデル内のファンクション指定。
        return $this->belongsToMany('App\Models\User', 'followusers', 'followed_user_id', 'following_user_id');
    }

     // フォロー→フォロワー
     public function follows()
     {
         return $this->belongsToMany('App\Models\User', 'followusers', 'following_user_id', 'followed_user_id');
     }

      //プロフィールモデルとのリレーション
    public function userprofile(){
        return $this->belongsTo('App\Models\Userprofile');
    } 
}
