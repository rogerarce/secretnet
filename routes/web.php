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
Route::get('/register', function () {
    return view('guest.register', [
        'types' => \App\Models\AccountType::all(),
    ]);
})->name('register');

Route::get('/', function() {
    return view('guest.login');
})->name('login');

// Guest Routes
Route::group(['middleware' => 'guest'], function() {
    Route::post('register', 'Recruit\AccountManager@register')->name('register');
    Route::post('login', 'Recruit\AccountManager@login')->name('login');
    Route::get('checkpin', 'Admin\Pins@checkPin')->name('checkPin');
});

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'Home@home')->name('adminhome'); 
    Route::get('/users', 'Home@users')->name('adminusers'); 
    Route::get('/pins', 'Home@pins')->name('adminpins'); 
    Route::get('/sales', 'Home@sales')->name('adminsales'); 

    // Business Scripts
    Route::resource('pin', 'Pins');
});

Route::group(['middleware' => 'auth', 'prefix' => 'user', 'namespace' => 'Recruit'], function() {
    Route::get('/', 'Navigation@home')->name('recruithome');
    Route::get('pins', 'Navigation@pins')->name('recruitpins');
    Route::get('tree', 'Navigation@tree')->name('recruittree');
    Route::get('recruit', 'Navigation@recruit')->name('recruitrecruit');


    Route::post('register_recruit', 'AccountManager@registerRecruit')->name('registerrecruit');
});

Route::post('logout', function() {
    \Auth::logout();
    return redirect('/');
})->name('logout');
