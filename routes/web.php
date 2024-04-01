<?php

use Illuminate\Support\Facades\Route;

/*
Route::get('/sup', function () {
    // return view('welcome');
    return 'Wazzup!!';
});

// DYNAMIC ROUTE
Route::get('/user/{id}/{name}', function ($id, $name) {
    // return view('welcome');
    return 'This is user '.$id. ' with the name of '.$name;
});
*/

// STATIC ROUTE
Route::get('/', 'App\Http\Controllers\PagesController@index');
Route::get('/about', 'App\Http\Controllers\PagesController@about');
Route::get('/services', 'App\Http\Controllers\PagesController@services');

Route::resource('posts', 'App\Http\Controllers\PostsController');
