<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
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
        $users = User::all();

        if ($posts->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No Posts or Users in the Database! No comments will be generated!');
            return;
        }

        $count = (int)$this->command->ask('How many comments for posts?', 150);

        Comment::factory()->count($count)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory()->count($count)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = User::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
