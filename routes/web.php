<?php

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ["auth"]], function () {

    Route::get( '/users', 'UsersController@index' )->name( 'users.index' );
    Route::get( '/user/{id}', 'UsersController@edit' )->name( 'users' );

    Route::get('navigation', 'NavigationController@index')->name('navigation');
//    Route::get( 'forms/colors/get-all', 'ColorController@getAll' )->name( 'colors.getAll' );

    Route::prefix('forms')->group(function () {
        Route::get( '/colors/get', 'ColorController@get' )->name( 'colors.get' );
        Route::resource('colors', 'ColorController');


//        Route::resource('capacities', 'CapacityController');
//        Route::get( 'capacities/get', 'CapacityController@get' )->name( 'capacities.get' );
//
//        Route::resource('customers', 'CustomerController');
//        Route::get( 'customers/get', 'CustomerController@get' )->name( 'customers.get' );
//
//        Route::resource('fault-types', 'FaultTypeController');
//        Route::get( 'fault-types/get', 'FaultTypeController@get' )->name( 'fault-types.get' );
//
//        Route::resource('grades', 'GradeController');
//        Route::get( 'grades/get-colors', 'GradeController@get' )->name( 'grades.get' );
//
//        Route::resource('makes', 'MakeController');
//        Route::get( 'makes/get', 'MakeController@get' )->name( 'makes.get' );
    });

});
