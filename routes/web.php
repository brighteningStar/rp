<?php

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ["auth"]], function () {

    Route::get( '/users', 'UsersController@index' )->name( 'users.index' );
    Route::get( '/user/{id}', 'UsersController@edit' )->name( 'users' );

    Route::get('navigation', 'NavigationController@index')->name('navigation');

    Route::prefix('forms')->group(function () {

        Route::get( '/colors/get', 'Forms\ColorController@get' )->name( 'colors.get' );
        Route::resource('colors', 'Forms\ColorController');

        Route::get( '/capacities/get', 'Forms\CapacityController@get' )->name( 'capacities.get' );
        Route::resource('capacities', 'Forms\CapacityController');

        Route::get( 'customers/get', 'Forms\CustomerController@get' )->name( 'customers.get' );
        Route::resource('customers', 'Forms\CustomerController');

        Route::get( 'fault-types/get', 'Forms\FaultTypeController@get' )->name( 'fault-types.get' );
        Route::resource('fault-types', 'Forms\FaultTypeController');

        Route::get( 'grades/get', 'Forms\GradeController@get' )->name( 'grades.get' );
        Route::resource('grades', 'Forms\GradeController');

        Route::get( 'makes/get', 'Forms\MakeController@get' )->name( 'makes.get' );
        Route::resource('makes', 'Forms\MakeController');

        Route::get( 'suppliers/get', 'Forms\SupplierController@get' )->name( 'suppliers.get' );
        Route::resource('suppliers', 'Forms\SupplierController');

        Route::get( 'regions/get', 'Forms\RegionController@get' )->name( 'regions.get' );
        Route::resource('regions', 'Forms\RegionController');

        Route::get( 'make-models/get', 'Forms\MakeModelController@get' )->name( 'make-models.get' );
        Route::resource('make-models', 'Forms\MakeModelController');

    });

});
