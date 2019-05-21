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
