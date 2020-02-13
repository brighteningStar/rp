<?php

//Auth::logout();
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get( '/', 'HomeController@index' )->name( 'home' );
Route::get( '/users', 'UsersController@index' )->name( 'users' );
Route::get( '/user/{id}', 'UsersController@edit' )->name( 'users' );
