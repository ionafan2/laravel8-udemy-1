<?php

/**
 * BCP
 *
 * @package App\View\Composers
 * @license Proprietary Software
 * @author  Pavlo Cherniavskyi
 */

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use \Illuminate\View\View;

class ActivityComposers
{

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $mostCommentedPosts = Cache::remember('blog-post-mostCommented', now()->addSeconds(60), function () {
            return BlogPost::mostCommented()->withCount('comments')->take(5)->get();
        });
        $mostActiveUsers = Cache::remember('users-mostActive', now()->addSeconds(60), function () {
            return User::mostBlogPosts()->take(5)->get();
        });
        $mostActiveUsersLastMonth = Cache::remember('users-mostActiveLastMonth', now()->addSeconds(60), function () {
            return User::mostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommentedPosts', $mostCommentedPosts);
        $view->with('mostActiveUsers',$mostActiveUsers );
        $view->with('mostActiveUsersLastMonth',$mostActiveUsersLastMonth );
    }

}
