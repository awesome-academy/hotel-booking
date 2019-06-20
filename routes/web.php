<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Client\HomeController@index')->name('index');

Route::get('/language/{id}', 'LanguageController@change')->name('changeLanguage');

Auth::routes();

Route::get('login', 'Auth\LoginController@form')->name('login_form');
Route::post('login', 'Auth\LoginController@authenticate')->name('login');
Route::post('register', 'Auth\LoginController@register')->name('register');
Route::get('/forget-password', 'Auth\LoginController@forgetPassword')->name('forgetPassword');
Route::post('/forget-password/submit', 'Auth\LoginController@sendForgetRequest')->name('forgetPasswordSubmit');
Route::get('/reset-password/', 'Auth\LoginController@reset')->name('reset');
Route::post('/reset-password/submit', 'Auth\LoginController@resetPassword')->name('resetPassword');

Route::prefix('rooms')->name('rooms.')->group(function () {
    $roomController = 'Client\RoomController@';
    Route::get('/', $roomController . 'index')->name('index');
    Route::get('/{location_id}', $roomController . 'location')->name('location');
    Route::get('/detail/{id}', $roomController . 'detail')->name('detail');
    Route::post('/detail/comment', $roomController . 'comment')->name('comment');
});

Route::prefix('booking')->name('booking.')->middleware('checkUserLogin')->group(function () {
    $bookingController = 'Client\BookingController@';
    Route::get('/', $bookingController . 'index')->name('index');
    Route::post('/submit', $bookingController . 'submit')->name('submit');
    Route::post('/checkout', $bookingController . 'checkout')->name('checkout');
    Route::post('/detail-booking', $bookingController . 'detailBooking')->name('detailBooking');
});
Route::prefix('blog')->group(function() {
    Route::get('/list/{cate_id}', 'Client\PostController@index')->name('blog.index');
    Route::get('/', 'Client\PostController@category');
    Route::get('/{id}/detail', 'Client\PostController@detail')->name('blog.detail');
    Route::post('/send', 'Client\PostController@comment');
    Route::get('/more/{id}', 'Client\PostController@more')->name('blog.more');
});
Route::prefix('users')->name('users.')->middleware('checkUserLogin')->group(function(){
    $userController = 'Client\UserController@';
    Route::get('/{id}', $userController . 'profile')->name('profile');
    Route::post('/update/{id}', $userController . 'update')->name('update');
    Route::post('/changepassword', $userController . 'changePassword')->name('changepassword');
    Route::get('show-info/{id}', $userController . 'showInfo')->name('showInfo');
    Route::post('update-info', $userController . 'updateInfo')->name('updateInfo');
});
Route::get('/contact/{loca_id}', 'Client\ContactController@index')->name('contact.index');
Route::post('/contact/send', 'Client\ContactController@send')->name('contact.send');

Route::prefix('chat-with-admin')->name('chatWithAdmin.')->group(function () {
    $chatController = 'Client\ChatController@';
    Route::post('submit-email', $chatController . 'submitEmail')->name('submitEmail');
    Route::post('send', $chatController . 'send')->name('send');
});
