<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /* 删除策略 */
    public function destroy(User $currentUser, Blog $currentBlog){
        /* 只能删除属于自己的blog */
        return $currentUser->id == $currentBlog->user_id;
    }

}
