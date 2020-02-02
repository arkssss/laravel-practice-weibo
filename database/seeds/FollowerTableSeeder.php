<?php

use Illuminate\Database\Seeder;

class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $all_users = \App\Models\User::all();
        $me = \App\Models\User::find(52);

        $followers = $all_users->slice('0','50');
        $followers_ids = $followers->pluck('id')->toArray();

        /* 关注所有 */
        $me->follow($followers_ids);

        /* 被所有关注 */
        foreach ($followers as $follower) {
            $follower->follow(52);
        }

    }
}
