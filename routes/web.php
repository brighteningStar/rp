<?php

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ["auth"]], function () {

    Route::get( '/users/get', 'UsersController@get' )->name( 'users.get' );
    Route::resource('users', 'UsersController');

    Route::get( '/roles/get', 'RolesController@get' )->name( 'roles.get' );

    Route::get('navigation', 'NavigationController@index')->name('navigation');

    Route::get('profile', 'UsersController@profile')->name('profile');
    Route::post( 'update-profile/{id}', 'UsersController@updateProfile' )->name( 'profile.update' );
    Route::post( 'update-password/{id}', 'UsersController@updatePassword' )->name( 'password.update' );


    Route::get( '/stock', 'StockController@index' )->name( 'stock.index' );
    Route::post( '/process-excel', 'StockController@processExcel' )->name( 'stock.excel' );
    Route::post( '/stock', 'StockController@store' )->name( 'stock.store' );
    Route::get( '/search', 'AttributesController@search' )->name( 'attribute.search' );

    Route::get( '/sales/get', 'SalesController@get' )->name( 'sales.get' );
    Route::get( '/search/imei', 'SalesController@searchImei' )->name( 'search.imei' );
    Route::resource( 'sales', 'SalesController' );

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

        Route::get( 'shipping-billings/get', 'Forms\ShippingBillingsController@get' )->name( 'shipping-billings.get' );
        Route::resource('shipping-billings', 'Forms\ShippingBillingsController');

        Route::get( 'bank-deals/get', 'Forms\BankDealsController@get' )->name( 'bank-deals.get' );
        Route::resource('bank-deals', 'Forms\BankDealsController');

    });

});
