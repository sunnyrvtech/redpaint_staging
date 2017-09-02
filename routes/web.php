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
Route::get('/home', 'HomeController@index')->name('home');
//routes for admin section start here
Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('packages', 'Admin\PackageController');
    Route::resource('categories', 'Admin\CategoryController');
    Route::post('categories/status', 'Admin\CategoryController@categoryStatus')->name('categories-status');
    Route::resource('users', 'Admin\UserController');
    Route::post('users/status', 'Admin\UserController@userStatus')->name('users-status');
});
//routes for admin section end here
//Auth::routes();
//Auth routes start here
Route::get('login', 'Auth\LoginController@index')->name('login');
//Route::get('password/email', 'Auth\ForgotPasswordController@index');
//Route::post('password/email', 'Auth\ForgotPasswordController@getEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@index')->name('password-reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@index')->name('register');
Route::post('register', 'Auth\RegisterController@create');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('account/activate/{code}', array(
    'as' => 'account.activate',
    'uses' => 'AccountController@getActivate'
));
Route::group(['prefix' => 'account'], function () {
    Route::get('profile', 'AccountController@index')->name('account-profile');
    Route::get('password', function() {
        return view('accounts.password');
    })->name('account-password');
    Route::get('profile/overview', 'AccountController@renderProfile')->name('account-profile-overview');
    Route::get('ads_setting', 'SubscriptionController@index')->name('account-ads_setting');
    Route::get('ads', 'SubscriptionController@addAdspace')->name('account-ads');
    Route::get('events', 'EventController@index')->name('account-events');
    Route::post('subscription/join', 'SubscriptionController@postJoin')->name('account-subscription-join');
});

Route::get('/{provider}/redirect', 'SocialAuthController@redirect');
Route::get('/{provider}/callback/', 'SocialAuthController@callback');

//Auth routes end here

Route::post('stripe/webhook',function(){
    return 'hello';
});



