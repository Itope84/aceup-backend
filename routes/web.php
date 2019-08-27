<?php

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

Route::get('/dashboard/{any?}', function () {
    return view('layouts.dashboard-master');
})->where('any', '.*')->middleware(['auth', 'is_privileged']);

Route::group(['middleware' => ['is_privileged'], 'namespace' => 'Api\Super', 'prefix' => '/api/super'], function () {
    Route::post('/upload-image', 'GeneralController@uploadImage');
    
    // courses
    Route::get('/courses', 'CourseController@index');
    Route::post('/courses', 'CourseController@store');
    Route::get('/courses/{course}', 'CourseController@show');
    Route::put('/courses/{course}', 'CourseController@update');

    // Topics
    Route::get('/topics', 'TopicController@index');
    Route::post('/topics', 'TopicController@store');
    Route::get('/topics/{topic}', 'TopicController@show');
    Route::put('/topics/{topic}', 'TopicController@update');

    // Slides
    Route::get('/slides', 'SlideController@index');
    Route::post('/slides', 'SlideController@store');
    Route::get('/slides/{slide}', 'SlideController@show');
    Route::put('/slides/{slide}', 'SlideController@update');

    // Questions
    Route::get('/questions', 'QuestionController@index');
    Route::post('/questions', 'QuestionController@store');
    Route::get('/questions/{question}', 'QuestionController@show');
    Route::put('/questions/{question}', 'QuestionController@update');

    // Users
    Route::middleware(['is_super'])->group(function () {
        Route::get('/users', 'UserController@index');
        Route::post('/users', 'UserController@store');
    });

});

Route::get('/mail/test', function () {
    Mail::raw('Testing email', function ($message) {
        $message->to(request()->email);
    });

    dd("Email sent!");
});
