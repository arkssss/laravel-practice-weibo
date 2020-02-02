{{-- 获得所有关注用户 --}}
<a href="{{route('users.followers', $user->id)}}">
  <strong id="following" class="stat">
    {{ count($user->followings) }}
  </strong>
  关注
</a>
{{-- 获得所有粉丝 --}}
<a href="{{route('users.followings', $user->id)}}">
  <strong id="followers" class="stat">
    {{ count($user->followers) }}
  </strong>
  粉丝
</a>
{{-- 查看所有微博 --}}
<a href="{{route('users.show', $user->id)}}">
  <strong id="statuses" class="stat">
    {{ $user->blogs()->count() }}
  </strong>
  微博
</a>
