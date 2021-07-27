<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware'=>'auth','admin'],function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::resource('category','CategoryController');
    Route::resource('product','ProductController');
});
Route::group(['middleware'=>'auth','user'],function(){
    Route::get('/user', 'UserController@index')->name('user');
    Route::resource('category','CategoryController');
    Route::resource('product','ProductController');
    // Route::resource('user','UserController');
});

// Route::get('/home', 'HomeController@index')->name('home');
