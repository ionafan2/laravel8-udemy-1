<?php

namespace App\Providers;

use App\Contracts\CounterContract;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Services\Counter;
use App\View\Composers\ActivityComposers;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Resources\Json\JsonResource;
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
        $this->app->singleton(Counter::class, function ($app) {
            return new Counter(
                $app->make(Factory::class),
                $app->make(Session::class),
                env('COUNTER_TIMEOUT')
            );
        });

        $this->app->bind(
            CounterContract::class,
            Counter::class
        );

//        \App\Http\Resources\Comment::withoutWrapping();
        JsonResource::withoutWrapping();
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
