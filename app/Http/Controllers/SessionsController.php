<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class SessionsController extends Controller
{
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
            return redirect()->route('users.show', [Auth::user()]);

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
