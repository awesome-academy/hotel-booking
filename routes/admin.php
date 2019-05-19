<?php

Route::get('/', 'Admin\HomeController@index')->name('index');

Route::resource('users', 'Admin\UserController');
