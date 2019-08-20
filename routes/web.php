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
});

Route::get('/mail/test', function () {
    Mail::raw('Testing email', function ($message) {
        $message->to(request()->email);
    });

    dd("Email sent!");
});
