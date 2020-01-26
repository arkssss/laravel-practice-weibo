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
        if(Auth::attempt($basicValidate)){
            session()->flash('success', '登陆成功');
            return redirect()->route('users.show', [Auth::user()]);
                
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    }
}
