<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
Route::get('/', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');
Route::get('/logout', 'LoginController@getLogout');

Route::any('stripe/webhook', 'Webhooks\StripeController@handleStripeWebhookEvents');

/*Admin routes*/
Route::group(['prefix' => 'admin','middleware' => ['auth', 'admin']], function () {
	
	Route::get('dashboard', 'Admin\AdminDashboardController@getDashboard');
	Route::controller('dashboard', 'Admin\AdminDashboardController');
	Route::controller('customer', 'Admin\AdminCustomerController');
	Route::controller('settings', 'Admin\AdminSettingsController');
	
});
	

/*Customer/Simple User routes*/
Route::group(['prefix' => 'user','middleware' => 'auth'], function () {
	
	Route::get('dashboard', 'User\UserDashboardController@getDashboard');
	Route::get('delete/{id}', 'User\UserDashboardController@delete');
	Route::controller('dashboard', 'User\UserDashboardController');
	Route::controller('account', 'User\UserAccountController');

	Route::resource('card', 'CardController');

});

