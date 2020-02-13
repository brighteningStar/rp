<?php

//Auth::logout();
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ["auth"]], function () {

    Route::get( '/users', 'UsersController@index' )->name( 'users.index' );
    Route::get( '/get-colors', 'ColorController@getColors' )->name( 'get.colors' );
    Route::get( '/user/{id}', 'UsersController@edit' )->name( 'users' );
    Route::resource('colors', 'ColorController');
    Route::get('navigation', 'NavigationController@index')->name('navigation');


});
