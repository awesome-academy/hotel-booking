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
    Route::get('/edit/{id}', $roomController . 'edit')->name('edit');
    Route::post('/update/{id}', $roomController . 'update')->name('update');
    Route::get('/translate/{parent_id}', $roomController . 'translate')->name('translate');
    Route::post('/translate/store', $roomController . 'translateStore')->name('translate.store');
    Route::get('/show-original/{id}', $roomController . 'showOriginal')->name('showOriginal');
});
