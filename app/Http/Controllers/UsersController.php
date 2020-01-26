<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

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

        // 后台表单验证
        // 如果验证出错, 则直接重定向
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


        Auth::attempt();

        // 重定向到个人信息页
        // 注意这是以 GET 方法重定向
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user->id]);

    }
}
