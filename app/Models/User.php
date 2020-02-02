<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function followers(){

        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');

    }

    public function followings(){

        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');

    }

    public function blogs(){

        return $this->hasMany(Blog::class);

    }

    /* 返回该用户关注的人发的微博 */
    public function feed(){

        return $this->blogs()->orderBy('created_at', 'desc');

    }
}
