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


    Route::get( '/report', 'ReportController@index' )->name( 'report.index' );
    Route::get( '/fetch-report', 'ReportController@fetch' )->name( 'report.fetch' );

    Route::get('search-by-imei', 'SearchController@searchByIMEI')->name('imei-search');

    Route::get( '/stock', 'StockController@index' )->name( 'stock.index' );
    Route::post( '/process-excel', 'StockController@processExcel' )->name( 'stock.excel' );
    Route::post( '/stock', 'StockController@store' )->name( 'stock.store' );
    Route::post( '/stock/{id}/update', 'StockController@update' )->name( 'stock.update' );
    Route::get( '/search', 'AttributesController@search' )->name( 'attribute.search' );
    Route::get( '/get-stock', 'StockController@getStock' )->name( 'get.stock' );
    Route::get( '/stock/edit/{id}', 'StockController@edit' )->name( 'edit.stock' );
    Route::get( '/fetch-stock/{id}', 'StockController@fetchStock' )->name( 'fetch.stock' );

    Route::get( '/sales/get', 'SalesController@get' )->name( 'sales.get' );
    Route::get( '/sales/{id}/view', 'SalesController@view' )->name( 'sales.view' );
    Route::post( '/sales/search/imei', 'SalesController@searchImei' )->name( 'sales.search.imei' );
    Route::resource( 'sales', 'SalesController' );

    Route::get( '/rma/get', 'RMAController@get' )->name( 'rma.get' );
    Route::get( '/rma/{id}/view', 'RMAController@view' )->name( 'rma.view' );
    Route::get( '/rma/search/imei', 'RMAController@searchImei' )->name( 'rma.search.imei' );
    Route::resource( 'rma', 'RMAController' );

    Route::get( '/supplier-credit/get', 'SupplierCreditController@get' )->name( 'supplier-credit.get' );
    Route::get( '/supplier-credit/{id}/view', 'SupplierCreditController@view' )->name( 'supplier-credit.view' );
    Route::get( '/supplier-credit/search/imei', 'SupplierCreditController@searchImei' )->name( 'supplier-credit.search.imei' );
    Route::resource( 'supplier-credit', 'SupplierCreditController' );

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

        Route::get( 'locations/get', 'Forms\LocationsController@get' )->name( 'locations.get' );
        Route::resource('locations', 'Forms\LocationsController');

    });

});
