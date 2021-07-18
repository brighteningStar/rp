<?php

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');
Route::get( 'get/roles', 'RolesController@get' )->name( 'roles.get' );

Route::group(['middleware' => ["auth"]], function () {

});
