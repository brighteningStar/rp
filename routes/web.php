<?php

Auth::routes();


Route::get('/', 'Auth\LoginController@showLoginForm')->name('home');
Route::get( 'get/roles', 'RolesController@get' )->name( 'roles.get' );

Route::group(['middleware' => ["auth"]], function () {
    Route::get( '/dashboard', 'DashboardController@index' )->name( 'dashboard.index' );
});
