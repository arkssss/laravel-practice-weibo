<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/">Weibo App</a>
      <ul class="navbar-nav justify-content-end">
      {{--  如果用已经登陆    --}}
        @if (Auth::check())
          <li class="nav-item"><a class="nav-link" href="{{route('users.index')}}">用户列表</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{route('users.show', Auth::user())}}">个人中心</a>
              <a class="dropdown-item" href="{{route('users.edit', Auth::user())}}">编辑资料</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" id="logout" href="#">
                <form action="{{ route('logout') }}" method="POST">
                  {{ csrf_field() }}
                  {{--   可以模拟出浏览器发出 delete 请求  --}}
                  {{ method_field('DELETE') }}
                  <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                </form>
              </a>
            </div>
          </li>
        @else
        <li class="nav-item"><a class="nav-link" href="{{ route('help') }}">帮助</a></li>
        {{-- 两者写法效果一样 , 但是上面的写法容错性高--}}
        {{-- <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li> --}}
        <li class="nav-item" ><a class="nav-link" href="{{route('login')}}">登录</a></li>
        @endif
      </ul>
    </div>
  </nav>
