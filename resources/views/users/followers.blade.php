@extends('layouts.default')
@section('title', '你的粉丝')

@section('content')
  <div class="offset-md-2 col-md-8">
    <h2 class="mb-4 text-center">{{$user->name}}的粉丝</h2>

    <div class="list-group list-group-flush">
      @foreach ($followers as $user)
        @include('users._user')
      @endforeach
    </div>

    <div class="mt-3">
      {!! $followers->render() !!}
    </div>

  </div>
@stop
