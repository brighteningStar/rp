<?php

//Auth::logout();
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ["auth"]], function () {

    Route::resource('users', 'UserController');
    Route::get('navigation', 'NavigationController@index')->name('navigation');


});
