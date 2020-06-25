<?php

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

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', 'PostController@create')->name('post.create');
    Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');
    Route::post('/posts', 'PostController@store')->name('post.store');
    Route::put('/posts/{post}', 'PostController@update')->name('post.update');

    Route::post('/posts/{post}/comments','CommentController@store')->name('comment.store');
    Route::post('/comments/{comment}/replies','CommentReplyController@store')->name('commentReply.store');

    Route::post('/comments/{id}/vote', 'CommentVoteController@store')->name('vote.store');


});
Route::get('/', 'PostController@index')->name('post.index');
Route::get('/posts/{post}', 'PostController@show')->name('post.show');

Route::get('/about', function () {
    return view('pages/about');
});

Route::get('/contact', function () {
    return view('pages/contact');
});

Route::get('/category', function () {
    return view('pages/category');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
