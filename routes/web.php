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
    Route::post('profile/update', 'AccountController@updateProfile')->name('profile-update');
    Route::get('password', function() {
        return view('accounts.password');
    })->name('account-password');
    Route::post('change/password', 'AccountController@changePassword')->name('change-password');
    Route::get('profile/overview', 'AccountController@renderProfile')->name('account-profile-overview');

    Route::resource('events', 'EventController');
    Route::group(['prefix' => 'events'], function () {
        Route::resource('photo', 'EventImageController');
    });
    Route::post('events/status/{status}', 'EventController@eventStatus')->name('events-status');
    Route::get('subscription', 'SubscriptionController@index')->name('account-subscription');
    Route::post('subscription/join', 'SubscriptionController@subscriptionJoin')->name('account-subscription-join');
    Route::post('subscription/change', 'SubscriptionController@subscriptionChange')->name('account-subscription-change');
    Route::post('subscription/cancel', 'SubscriptionController@subscriptionCancel')->name('account-subscription-cancel');
    Route::post('subscription/resume', 'SubscriptionController@subscriptionResume')->name('account-subscription-resume');
    Route::post('subscription/card', 'SubscriptionController@updateCard')->name('account-subscription-card');
});

Route::get('/{provider}/redirect', 'SocialAuthController@redirect');
Route::get('/{provider}/callback/', 'SocialAuthController@callback');

//Auth routes end here

Route::post(
        'stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);



