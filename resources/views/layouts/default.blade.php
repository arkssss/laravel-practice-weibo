<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
    @include('layouts._header')


    <div class="container">

        <div class="offset-md-1 col-md-10">
          {{-- 消息提示页 --}}
          @include('shared._messages')
          @yield('content')
          @include('layouts._footer')
        </div>
    </div>
    {{--  引入 app 的js 文件 --}}
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
