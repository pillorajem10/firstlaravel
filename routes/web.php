<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

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
Route::resource('categories', 'App\Http\Controllers\CategoryController');
Route::resource('products', 'App\Http\Controllers\ProductsController');
// Route::resource('carts', 'App\Http\Controllers\CartController');

// Defining cart routes individually
Route::get('carts', [CartController::class, 'index'])->name('carts.index');
Route::get('carts/{cartid}/{cartproductid}', [CartController::class, 'show'])->name('carts.show');
Route::post('carts', [CartController::class, 'store'])->name('carts.store');
Route::put('/carts/{cart}/update/{cartproductid}', [CartController::class, 'update'])->name('carts.update');
Route::delete('carts/{cartid}/{cartproductid}', [CartController::class, 'destroy'])->name('carts.destroy');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
