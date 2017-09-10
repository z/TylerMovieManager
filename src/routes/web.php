<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/developers', 'DeveloperTokensController@index')->middleware('auth');

Route::get('/home', function () {
    return view('movies');
})->middleware('auth');

Route::get('/example', function () {
    return view('example');
});

Route::get('/movies', function () {
    return view('movies');
})->middleware('auth');
