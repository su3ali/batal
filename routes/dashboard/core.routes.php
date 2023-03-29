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
    Route::resource('category', 'CategoryController');

    Route::resource('technician', 'TechnicianController');
    Route::get('technician/change_status/change', 'TechnicianController@changeStatus')->name('technician.change_status');

    Route::resource('group', 'GroupsController');
});

