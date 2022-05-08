<?php /** @noinspection ALL */

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
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

Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('/single', AboutController::class);

Route::resource('posts', PostsController::class);

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ]
];

Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return "<h1> Post #</h1>" . $daysAgo;
})->name('posts.recent.index');


Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {

    Route::get('/response', function () use ($posts) {
        return response($posts, 201)
            ->header('Content-Type', 'application/json')
            ->cookie('MYCOOKIE', 'TEST', '3600');
    })->name('response');

    Route::get('/redirect', function () {
        return redirect('/contact');
    })->name('redirect');


    Route::get('/back', function () {
        return back();
    })->name('back');


    Route::get('/named', function () {
        return redirect()->route('posts.show', ['id' => 2]);
    })->name('named');

    Route::get('/away', function () {
        return redirect()->away('https://google.com');
    })->name('away');


    Route::get('/json', function () use ($posts) {
        return response()->json($posts);
    })->name('json');

    Route::get('/download', function () use ($posts) {
        return response()->download(public_path('/MVC.png'), 'test.png');
    })->name('download');

});



























