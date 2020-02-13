<?php

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ["auth"]], function () {

    Route::get( '/users', 'UsersController@index' )->name( 'users.index' );
    Route::get( '/user/{id}', 'UsersController@edit' )->name( 'users' );

    Route::get('navigation', 'NavigationController@index')->name('navigation');

    Route::resource('colors', 'ColorController');
    Route::get( '/get-colors', 'ColorController@getColors' )->name( 'colors.get' );


});
