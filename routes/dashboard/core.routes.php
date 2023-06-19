<?php



route_group('core', function () {

    route_group('administration', function () {
        Route::resource('profile', 'AdminProfileController')->except(['create','store','delete', 'show']);
        Route::group(['prefix' => 'roles'], function (){
            Route::get('/', 'RoleController@index')->name('roles.index')->middleware('permission:view_roles');
            Route::get('/create', 'RoleController@create')->name('roles.create')->middleware('permission:create_roles');
            Route::post('/', 'RoleController@store')->name('roles.store')->middleware('permission:create_roles');
            Route::get('/{id}/edit', 'RoleController@edit')->name('roles.edit')->middleware('permission:update_roles');
            Route::post('/{id}', 'RoleController@update')->name('roles.update')->middleware('permission:update_roles');
            Route::get('/{id}/delete', 'RoleController@destroy')->name('roles.destroy')->middleware('permission:delete_roles');
        });
        Route::group(['prefix' => 'admins'], function (){
            Route::get('/', 'AdminController@index')->name('admins.index')->middleware('permission:view_admins');
            Route::get('/create', 'AdminController@create')->name('admins.create')->middleware('permission:create_admins');
            Route::post('/', 'AdminController@store')->name('admins.store')->middleware('permission:create_admins');
            Route::get('/{id}/edit', 'AdminController@edit')->name('admins.edit')->middleware('permission:update_admins');
            Route::post('/{id}', 'AdminController@update')->name('admins.update')->middleware('permission:update_admins');
            Route::get('/{id}/delete', 'AdminController@destroy')->name('admins.destroy')->middleware('permission:delete_admins');
            Route::get('/change_status', 'AdminController@change_status')->name('admins.change_status');
        });

    });


    Route::get('category/change_status', 'CategoryController@change_status')->name('category.change_status');
    Route::get('service/change_status', 'ServiceController@change_status')->name('service.change_status');

    Route::resource('category', 'CategoryController');

    Route::resource('technician', 'TechnicianController');
    Route::get('technician/change_status/change', 'TechnicianController@changeStatus')->name('technician.change_status');
    Route::resource('tech_specializations', 'TechSpecializationController');
    Route::get('tech_specializations/change_status/change', 'TechSpecializationController@change_status')->name('tech_specializations.change_status');

    Route::resource('service', 'ServiceController');
    Route::post('service/get/image', 'ServiceController@getImage')->name('service.getImage');
    Route::post('service/image', 'ServiceController@uploadImage')->name('service.uploadImage');
    Route::post('service/delete/image', 'ServiceController@deleteImage')->name('service.deleteImage');

    Route::resource('group', 'GroupsController');

    Route::get('customer_wallet',  'CustomerWalletController@index')->name('customer_wallet.index');
    Route::post('customer_wallet',  'CustomerWalletController@store')->name('customer_wallet.store');
    Route::post('customer_wallet/{id}', 'CustomerWalletController@update')->name('customer_wallet.update');


    Route::get('technician_wallet',  'TechnicianWalletController@index')->name('technician_wallet.index');
    Route::post('technician_wallet',  'TechnicianWalletController@store')->name('technician_wallet.store');
    Route::post('technician_wallet/{id}', 'TechnicianWalletController@update')->name('technician_wallet.update');


    Route::get('customer/change_status', 'CustomerController@change_status')->name('customer.change_status');
    Route::resource('customer', 'CustomerController');

    Route::get('address/change_status', 'AddressController@change_status')->name('address.change_status');
    Route::get('address/getCity', 'AddressController@getCityBycountry')->name('address.getCity');
    Route::get('address/getRegion', 'AddressController@getRegionByCity')->name('address.getRegion');
    Route::resource('address', 'AddressController');


    Route::resource('measurements', 'MeasurementsController');
    Route::get('measurements/change_status/change', 'MeasurementsController@change_status')->name('measurements.change_status');

    Route::get('icon/change_status', 'ServiceIconController@change_status')->name('icon.change_status');
    Route::resource('icon', 'ServiceIconController');



});

