<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Blog;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Blog::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'user_id' => 1,
        'content' => $faker->text(100),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
