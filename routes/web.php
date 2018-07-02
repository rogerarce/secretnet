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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'Home@home')->name('adminhome'); 
    Route::get('/users', 'Home@users')->name('adminusers'); 
    Route::get('/pins', 'Home@pins')->name('adminpins'); 

    // Business Scripts
    Route::resource('pin', 'Pins');
});

Route::group(['prefix' => 'user', 'namespace' => 'Customer'], function() {
    Route::get('/', 'Home@home'); 
});
