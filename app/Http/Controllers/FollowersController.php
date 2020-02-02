<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FollowersController extends Controller
{
    //

    public function __construct()
    {
        /* 登陆授权 */
        $this->middleware(
            'auth', ['only' => 'store', 'destroy']
        );
    }

    /* 关注 */
    public function store(User $user){

        /* user 不能是当前的登陆用户 */
        $this->authorize('notSameUser', $user);

        $currentUser = Auth::user();

        $currentUser->follow($user->id);

        session()->flash("success", "关注成功");

        return redirect()->back();
    }


    /* 取关 */
    public function destroy(User $user){

        $this->authorize('notSameUser', $user);

        $currentUser = Auth::user();

        $currentUser->unfollow($user->id);

        session()->flash("success", "取关成功");

        return redirect()->back();
    }



}
