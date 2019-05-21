<?php

Route::get('/', 'Admin\HomeController@index')->name('index');

/**
 * User Manage
 */
Route::resource('users', 'Admin\UserController');
Route::post('users/change-password', 'Admin\UserController@changePassword')->name('users.changepassword');

/**
 *Locations Manage
 */
Route::resource('locations', 'Admin\LocationController');

/**
 * Room manage
 */
Route::prefix('/{location_id}/rooms')->name('rooms.')->group(function () {
    $roomController = 'Admin\RoomController@';
    Route::get('/', $roomController . 'index')->name('index');
    Route::get('/create', $roomController . 'create')->name('create');
    Route::post('/store', $roomController . 'store')->name('store');
    Route::get('/edit/{room_id}', $roomController . 'edit')->name('edit');
    Route::post('/update/{room_id}', $roomController . 'update')->name('update');
});
