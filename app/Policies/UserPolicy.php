<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    /**
     * 用户更新策略
     * @param User $currentUser 当前用户
     * @param User $passUser 请求的用户
     * @return bool
     */
    public function update(User $currentUser, User $passUser){

        return $currentUser->id === $passUser->id;

    }
}
