<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 控制用户 CRUD 操作
class UsersController extends Controller
{
    // 创建用户
    public function create(){

        return view('users.create');

    }
}
