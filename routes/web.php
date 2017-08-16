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
    return view('index');
});
//routes for admin section start here
Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('/packages', 'Admin\PackageController');
});
//routes for admin section end here
//Route::get('/home', 'HomeController@index')->name('home');
//Auth::routes();
//Auth routes start here
Route::get('login', 'Auth\LoginController@index');
Route::get('password/email', 'Auth\ForgotPasswordController@index');
Route::post('password/email', 'Auth\ForgotPasswordController@getEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@index')->name('password-reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@index');
Route::post('register', 'Auth\RegisterController@create');
Route::get('logout', 'Auth\LoginController@logout');

//Auth routes end here



