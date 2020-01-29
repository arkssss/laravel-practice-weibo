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

    /**
     * 用户删除策略
     * @param User $currentUser
     * @param User $passUser
     * @return bool
     */
    public function destroy(User $currentUser, User $passUser){
        return $currentUser->is_admin && $currentUser->id !== $passUser->id;
    }
}
