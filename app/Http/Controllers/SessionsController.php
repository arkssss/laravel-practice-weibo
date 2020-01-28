<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{

    public function __construct()
    {
        // 表示 只有未登录的用户才能访问 login 页面
        $this->middleware('guest',
            ['only' => ['create']]
        );

    }


    // get 登陆
    public function create(){

        return view("sessions.login");

    }

    // 验证登陆
    public function store(Request $request){


        $basicValidate = $this->validate($request,
            [
                'password' => 'required',
                'email'=> 'required|email|max:255'
            ]
         );

        // 检测 basicValidate 是否存在与数据库中
        // 第二个传参为 bool 值，true 表示记住次用户
        if(Auth::attempt($basicValidate, $request->has('remember'))){
            // 登陆成功
            session()->flash('success', '登陆成功');
            $fallback = route('users.show', Auth::user());

            // intended() 表示重定向到用户上一次浏览的页面， 如果没有上一次，那么浏览 fallback
            return redirect()->intended($fallback);

        }else{
            // 登陆失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');

            // withInput() 表示回退的时候保存用户之前的输入信息
            return redirect()->back()->withInput();
        }

    }

    // 用户 logout
    public function delete(){

        Auth::logout();
        session()->flash('success', '退出成功');
        return redirect()->route('login');

    }

}
