<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

// 控制用户 CRUD 操作
class UsersController extends Controller
{
    // 创建用户
    public function create(){

        return view('users.create');

    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    // save user
    public function store(Request $request){

        // 验证
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        return;

    }
}
