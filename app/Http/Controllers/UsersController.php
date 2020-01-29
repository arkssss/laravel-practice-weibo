<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

// 控制用户 CRUD 操作
class UsersController extends Controller
{

    public function __construct()
    {
        // 表示除了这三个方法， 其他在执行前都需要调用中间件 auth
        $this->middleware('auth', [
            'except' => ['create', 'store', 'show', 'index']
        ]);


    }

    // 创建用户
    public function create(){

        return view('users.create');

    }

    // 显示用户
    public function show(User $user){
        return view('users.show', compact('user'));
    }

    // 显示所有用户
    public function index(){

        $users = User::paginate(10);

        return view('users.index', compact('users'));

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


        Auth::login($user);
        // 重定向到个人信息页
        // 注意这是以 GET 方法重定向
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user->id]);

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

    /**
     * 删除用户
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user){

        $this->authorize('destroy', $user);

        $user->delete();

        session()->flash('success', '删除成功');

//        $fallback = route('users.index');
//        return redirect()->intended($fallback);

        return back();

    }
}
