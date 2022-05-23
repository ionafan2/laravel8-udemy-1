<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\View\Composers\ActivityComposers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['posts.index', 'posts.show'], ActivityComposers::class);

        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
