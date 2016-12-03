<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Token API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Token API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "token" middleware group. Enjoy building your API!
|
*/

Route::resource('movies', 'MovieController', ['only' => [
    'index', 'show', 'create', 'store', 'update', 'destroy'
]]);

Route::resource('formats', 'FormatController', ['only' => [
    'index', 'show', 'create', 'store', 'update', 'destroy'
]]);
