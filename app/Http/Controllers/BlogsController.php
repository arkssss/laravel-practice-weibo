<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'auth', ['only' => 'store', 'destroy']
        );
    }


    // 新增 for POST
    public function store(Request $request){

        // 表单验证
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        $user = Auth::user();

        // 新增数据
        $user->blogs()->create([
            'content' => $request['content'],
        ]);

        session()->flash('success', '发送成功');

        return redirect()->back();

    }

    // 删除 for DELETE
    public function destroy(Blog $blog){

        /* 只能删除自己的微博 */
        $this->authorize('destroy', $blog);

        $blog->delete();
        session()->flash('success', '删除成功');
        return redirect()->back();
    }


}
