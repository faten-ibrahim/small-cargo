<?php
use Illuminate\Http\Request;

Route::post('company/login', 'Api\Company\AuthController@login');
Route::post('company/register', 'Api\Company\AuthController@register');

Route::post('driver/login', 'Api\Driver\AuthController@login');
Route::post('driver/register', 'Api\Driver\AuthController@register');
Route::post('company/order', 'Api\Company\CompaniesOrdersController@store');
Route::post('company/calc', 'Api\Company\CompaniesOrdersController@calc_total_estimated_cost');
// Route::post('company/loc', 'Api\Company\CompaniesOrdersController@get_nearest_drivers');
// Route::put('driver/accept_order/{id}', 'Api\Driver\DriversOrdersController@accept_order');
Route::put('company/confirm/{order_id}/{company_id}', 'Api\Company\CompaniesOrdersController@confirm_order');
Route::group([
    'middleware' => ['auth:company'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('company/logout', 'Api\Company\AuthController@logout');
    Route::get('company/me', 'Api\Company\AuthController@getAuthUser');
    Route::post('company/token', 'Api\Company\AuthController@get_fcm_token');
    Route::post('company/order', 'Api\Company\CompaniesOrdersController@store');
    Route::put('company/edit', 'Api\Company\AuthController@edit_profile');
    Route::get('company/currentOrders/{id}', 'Api\Company\CompaniesOrdersController@currentOrders');
    Route::get('company/lastOrders/{id}', 'Api\Company\CompaniesOrdersController@lastOrders');
    Route::put('company/confirm/{order_id}/{company_id}', 'Api\Company\CompaniesOrdersController@confirm_order');


});

Route::group([
    'middleware' => ['auth:driver-api'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('driver/logout', 'Api\Driver\AuthController@logout');
    Route::get('driver/me', 'Api\Driver\AuthController@getAuthUser');
    Route::post('driver/token', 'Api\Driver\AuthController@get_fcm_token');
    Route::post('driver/location', 'Api\Driver\AuthController@post_driver_location');
    Route::get('drivers/{driver}', 'Api\Driver\AuthController@get_driver_location');
    Route::put('driver/edit', 'Api\Driver\AuthController@edit_profile');
    Route::get('driver/current_order/{id}', 'Api\Driver\DriversOrdersController@current_order');
    Route::get('driver/last_order/{id}', 'Api\Driver\DriversOrdersController@last_order');

    Route::put('driver/accept_order/{id}', 'Api\Driver\DriversOrdersController@accept_order');
    Route::put('driver/start_trip/{id}', 'Api\Driver\DriversOrdersController@start_trip');
    Route::put('driver/deliver/{id}', 'Api\Driver\DriversOrdersController@delivere_order');

});

Route::get('company/get_driver/{id}', 'Api\Company\CompaniesOrdersController@get_driver');
Route::get('company/lastOrders/{id}', 'Api\Company\CompaniesOrdersController@lastOrders');
