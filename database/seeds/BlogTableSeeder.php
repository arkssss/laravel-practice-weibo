<?php

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $blogs = factory(Blog::class)->times(5)->make();
        Blog::insert($blogs->toArray());
    }
}
