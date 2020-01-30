<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

// 控制用户 CRUD 操作
class UsersController extends Controller
{

    public function __construct()
    {
        // 表示除了这三个方法， 其他在执行前都需要调用中间件 auth
        $this->middleware('auth', [
            'except' => ['create', 'store', 'show', 'index', 'confirmEmail']
        ]);


    }

    // 注册用户页面
    public function create(){

        return view('users.create');

    }

    // 显示单个用户
    public function show(User $user){
        return view('users.show', compact('user'));
    }

    // 显示所有用户
    public function index(){

        $users = User::paginate(10);

        return view('users.index', compact('users'));

    }

    // 注册用户
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


//        Auth::login($user);
        $this->sendEmailConfirmationTo($user);

        // 重定向到个人信息页
        // 注意这是以 GET 方法重定向
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('home');
    }

    // 获得编辑页面
    public function edit(User $user){

        $this->authorize('update', $user);

        return view('users.edit', compact('user'));

    }

    // 更新用户
    public function update(User $user, Request $request){

        // 利用 UserPolicy 策略的 update 方法， 验证此时的user
        $this->authorize('update', $user);

        $this->validate($request,
            [
                'name' => 'required|max:50',
                'password' => 'required|confirmed|min:6'
            ]
        );

        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }

    // 删除用户
    public function destroy(User $user){

        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '删除成功');

//        $fallback = route('users.index');
//        return redirect()->intended($fallback);

        return back();

    }

    // 发送邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    // 确认邮件
    public function confirmEmail($token){

        $user = User::where('activation_token', $token)->firstOrFail();
        $user-> activated = true;
        $user-> activation_token = null;

        $user->save();
        Auth::login($user);

        session()->flash('success', '账号激活成功！');
        return redirect()->route('users.show',$user);
    }
}
