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

Route::get('/', function () {
    
    return view('welcome');
})->name('index');
Route::get('/hotel', 'HomeController@index');
Route::group(['middleware' => 'locale'], function() {
    Route::get('/language/{locale}', 'HomeController@changeLanguage');
});

Auth::routes();
Route::get('login', 'Auth\LoginController@form')->name('login_form');
Route::post('login', 'Auth\LoginController@authenticate')->name('login');
