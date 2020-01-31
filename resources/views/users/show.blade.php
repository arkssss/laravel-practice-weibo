@extends('layouts.default')
@section('title', $user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <div class="col-md-12">
      <div class="offset-md-2 col-md-8">
        <section class="user_info">
            {{-- 第二参数为给 _user_info 页面的传参 --}}
          @include('shared._user_info', ['user' => $user])
        </section>
        @if ($blogs->count() > 0)
          <ul class="list-unstyled">
            @foreach ($blogs as $blog)
              @include('blog._blog')
            @endforeach
          </ul>
          <div class="mt-5">
            {!! $blogs->render() !!}
          </div>
        @else
          <p>没有数据！</p>
          @endif
          </section>
      </div>
    </div>
  </div>
</div>
@stop
