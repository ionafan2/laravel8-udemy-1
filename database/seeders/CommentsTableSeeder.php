<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();

        if($posts->isEmpty()) {
            $this->command->warn('No Posts in Database! No comments will be generated!');
            return;
        }

        $count = (int)$this->command->ask('How many posts?', 150);

        Comment::factory()->count($count)->make()->each(function ($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
