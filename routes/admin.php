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
    Route::get('/delete/{id}', $roomController . 'delete')->name('delete');
    Route::post('/add-properties', $roomController . 'addProperties')->name('addProperties');
    Route::post('/delete-properties', $roomController . 'deleteProperties')->name('deleteProperties');
});
Route::post('/rooms/upload-images/{id}', 'Admin\RoomController@uploadImage')->name('rooms.uploadImage');
Route::post('/rooms/destroy-images', 'Admin\RoomController@destroyImage')->name('rooms.destroyImage');
Route::post('/rooms/delete-room-number', 'Admin\RoomController@deleteRoomNumber')->name('rooms.deleteRoomNumber');
Route::get('/rooms/delete-images/{id}', 'Admin\RoomController@deleteImage')->name('rooms.deleteImage');

/**
 * Properties manage
 */
Route::prefix('properties')->name('properties.')->group(function () {
    $propertyController = 'Admin\PropertyController@';
    Route::get('/', $propertyController . 'index')->name('index');
    Route::post('/', $propertyController. 'store')->name('store');
    Route::get('/edit/{id}', $propertyController . 'edit')->name('edit');
    Route::get('/translate/{lang_parent_id}', $propertyController . 'translate')->name('translate');
    Route::post('/translate/{lang_parent_id}/store', $propertyController . 'translateStore')->name('translateStore');
    Route::post('update/{id}', $propertyController . 'update')->name('update');
    Route::get('delete/{id}', $propertyController . 'delete')->name('delete');
});
Route::prefix('category')->group(function () {
    Route::get('/', 'Admin\CategoryController@index')->name('category.index');
    Route::get('/anyway', 'Admin\CategoryController@anyway')->name('categoy.Datatable');
    Route::post('/', 'Admin\CategoryController@store')->name('store');
    Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('edit');
    Route::post('/update', 'Admin\CategoryController@update')->name('update');
    Route::get('/{id}', 'Admin\CategoryController@destroy');
    Route::post('/trans', 'Admin\CategoryController@trans');
});
Route::prefix('post')->group(function () {
    Route::get('/', 'Admin\PostController@index')->name('post.index');
    Route::get('/anyway', 'Admin\PostController@anyway')->name('categoy.Datatable');
    Route::post('/', 'Admin\PostController@store')->name('store');
    Route::get('/{id}/edit', 'Admin\PostController@edit')->name('edit');
    Route::post('/update', 'Admin\PostController@update')->name('update');
    Route::get('/{id}', 'Admin\PostController@destroy');
    Route::get('/{id}/detail', 'Admin\PostController@edit');
    Route::post('/trans', 'Admin\PostController@trans');
});

/**
 * Invoice manage
 */
Route::prefix('/invoices')->name('invoices.')->group(function () {
    $invoiceController = 'Admin\InvoiceController@';
    Route::get('/', $invoiceController . 'index')->name('index');
    Route::get('/{id}', $invoiceController . 'show')->name('show');
    Route::get('/delete/{id}', $invoiceController . 'delete')->name('delete');
});

/**
 * Web setting manage
 */
Route::prefix('/web-setting')->name('web-setting.')->group(function () {
    $webSettingController = 'Admin\WebSettingController@';
    Route::get('/', $webSettingController . 'index')->name('index');
    Route::post('/update/{id}', $webSettingController . 'update')->name('update');
});
Route::prefix('contact')->name('contact.')->group(function() {
    Route::get('/', 'Admin\ContactController@index')->name('contact');
    Route::get('/anyway', 'Admin\ContactController@anyway')->name('Datatable');
    Route::get('/{id}', 'Admin\ContactController@delete')->name('delete');
});
Route::prefix('comment')->name('comment.')->group(function() {
    Route::get('/{object}', 'Admin\CommentController@index')->name('index');
    Route::get('/anyway/{object}', 'Admin\CommentController@anyway')->name('Datatable');
    Route::delete('/{id}', 'Admin\CommentController@delete')->name('delete');
});
Route::prefix('lang')->group(function() {
    Route::get('/', 'Admin\LanguageController@index');
    Route::get('/anyway', 'Admin\LanguageController@anyway')->name('laguage.Datatable');
    Route::post('/', 'Admin\LanguageController@store');
    Route::get('/{id}/edit', 'Admin\LanguageController@edit');
    Route::post('/update', 'Admin\LanguageController@update');
});
