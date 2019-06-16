<?php
use Illuminate\Http\Request;

Route::post('company/login', 'Api\Company\AuthController@login');
Route::post('company/register', 'Api\Company\AuthController@register');

Route::post('driver/login', 'Api\Driver\AuthController@login');
Route::post('driver/register', 'Api\Driver\AuthController@register');
// Route::post('company/order', 'Api\Company\CompaniesOrdersController@store');

Route::group([
    'middleware' => ['auth:company'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('company/logout', 'Api\Company\AuthController@logout');
    Route::get('company/me', 'Api\Company\AuthController@getAuthUser');
    Route::post('company/token', 'Api\Company\AuthController@get_fcm_token');
    Route::post('company/order', 'Api\Company\CompaniesOrdersController@store');
    Route::post('company/edit', 'Api\Company\AuthController@edit_profile');
    Route::get('company/currentOrders/{id}', 'Api\Company\CompaniesOrdersController@currentOrders');
    Route::get('company/lastOrders/{id}', 'Api\Company\CompaniesOrdersController@lastOrders');

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
    Route::post('driver/edit', 'Api\Driver\AuthController@edit_profile');

});

Route::get('company/get_driver/{id}', 'Api\Company\CompaniesOrdersController@get_driver');
Route::get('company/lastOrders/{id}', 'Api\Company\CompaniesOrdersController@lastOrders');

