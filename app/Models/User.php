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

    /* 返回粉丝 */
    public function followers(){

        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');

    }

    /* 返回关注的人 */
    public function followings(){

        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');

    }

    /* 关注 */
    public function follow($user_ids){

        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }

        /* 关注 */
        $this->followings()->sync($user_ids, false);

    }

    /* 取消关注 */
    public function unfollow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }

        /* 取消关注 */
        $this->followings()->detach($user_ids);
    }

    public function blogs(){

        return $this->hasMany(Blog::class);

    }

    /* 返回该用户关注的人发的微博 */
    public function feed(){

        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);
        return Blog::whereIn('user_id', $user_ids)
            ->with('user')
            ->orderBy('created_at', 'desc');

    }

    /* 当前用户是否关注了 user_id */
    public function isFollowing($user_id){

        return $this->followings->contains($user_id);

    }
}
