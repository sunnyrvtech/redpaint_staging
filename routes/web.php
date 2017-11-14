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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
//routes for admin section start here
Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('packages', 'Admin\PackageController');
    Route::resource('ads_list', 'Admin\AdController');
    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('business', 'Admin\EventController');
    Route::get('business/images/{id}', 'Admin\EventController@getEventImages')->name('business-images');
    Route::post('business/status', 'Admin\EventController@eventStatus')->name('business-status');
    Route::post('business/image/delete/{id}', 'Admin\EventController@deleteEventImage')->name('business.image.delete');
    Route::resource('reviews', 'Admin\ReviewController');
    Route::resource('static_page', 'Admin\StaticPageController');
    Route::post('reviews/status', 'Admin\ReviewController@reviewStatus')->name('reviews-status');
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
Route::get('search', 'EventController@searchEvent')->name('search');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('account/activate/{code}', array(
    'as' => 'account.activate',
    'uses' => 'AccountController@getActivate'
));
Route::get('events/autosearch', 'EventController@categoryAutosearch')->name('events-autosearch');
Route::get('address/autosearch', 'EventController@addressAutosearch')->name('address-autosearch');
Route::group(['prefix' => 'account', 'middleware' => 'CheckLoginStatus'], function () {
    Route::get('profile', 'AccountController@index')->name('account-profile');
    Route::post('profile/update', 'AccountController@updateProfile')->name('profile-update');
    Route::get('password', function() {
        return view('accounts.password');
    })->name('account-password');
    Route::post('change/password', 'AccountController@changePassword')->name('change-password');
    Route::get('profile/overview', 'AccountController@renderProfile')->name('account-profile-overview');

    Route::resource('events', 'EventController');
    Route::resource('ads', 'AdController');
    Route::get('payments', 'AccountController@getPaymentHistory')->name('payments');
    Route::group(['prefix' => 'events'], function () {
        Route::resource('photo', 'EventImageController');
        Route::get('photo/view/{slug}', 'EventImageController@getAllEventImages')->name('photo.view');
    });
    Route::post('events/review/{id}', 'EventController@addReview')->name('events-review');
    Route::post('events/status/{status}', 'EventController@eventStatus')->name('events-status');
    Route::get('subscription', 'SubscriptionController@index')->name('account-subscription');
    Route::post('subscription/join', 'SubscriptionController@subscriptionJoin')->name('account-subscription-join');
    Route::post('subscription/change', 'SubscriptionController@subscriptionChange')->name('account-subscription-change');
    Route::post('subscription/cancel', 'SubscriptionController@subscriptionCancel')->name('account-subscription-cancel');
    Route::post('subscription/resume', 'SubscriptionController@subscriptionResume')->name('account-subscription-resume');
    Route::post('subscription/card', 'SubscriptionController@updateCard')->name('account-subscription-card');
});

Route::get('events/{slug}', 'EventController@getEventByslug')->name('events');

Route::get('/{provider}/redirect', 'SocialAuthController@redirect');
Route::get('/{provider}/callback/', 'SocialAuthController@callback');

//Auth routes end here

Route::post('stripe/webhook', 'SubscriptionController@paymentStatus');



