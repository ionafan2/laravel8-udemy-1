<?php /** @noinspection ALL */

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserControler;
use App\Mail\CommentPostedMarkdown;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'home'])->name('home.index');

Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::resource('posts', PostsController::class);

Route::get('/posts/tag/{id}', [PostTagController::class, 'index'])->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);

Route::resource('user', UserControler::class)->only(['show', 'edit', 'update']);

Route::get('mailable', function () {
    $comment = Comment::find(1);
    return new CommentPostedMarkdown($comment);
});
