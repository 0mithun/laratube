<?php

use App\Http\Controllers\UploadVideoController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('channels', 'ChannelController');

Route::get('/videos/{video}', 'VideoController@show')->name('video.show');
Route::put('/videos/{video}', 'VideoController@updateView')->name('video.watch');

Route::get('/videos/{video}/comments', 'CommentController@index');
Route::get('/comments/{comment}/replies', 'CommentController@replies');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('channels/{channel}/subscriptions', 'SubscriptionController')->only(['store', 'destroy']);
    Route::get('channels/{channel}/videos', [UploadVideoController::class, 'index'])->name('channel.upload');
    Route::post('channels/{channel}/videos', [UploadVideoController::class, 'store']);

    Route::put('/video{video}', 'VideoController@update')->name('video.update');

    Route::post('/votes/{entityId}/{type}', 'VoteController@vote');

    Route::post('/comments/{video}', 'CommentController@store');
});
