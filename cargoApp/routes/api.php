<?php
use Illuminate\Http\Request;

Route::post('company/login', 'Api\Company\AuthController@login');
Route::post('company/register', 'Api\Company\AuthController@register');

Route::get('driver/driversNotification','Api\Company\CompaniesOrdersController@driversNotification');

Route::post('driver/login', 'Api\Driver\AuthController@login');
Route::post('driver/register', 'Api\Driver\AuthController@register');
Route::post('company/order', 'Api\Company\CompaniesOrdersController@store');

Route::group([
    'middleware' => ['auth:company'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('company/logout', 'Api\Company\AuthController@logout');
    Route::get('company/me', 'Api\Company\AuthController@getAuthUser');
    Route::post('company/token', 'Api\Company\AuthController@get_fcm_token');
    // Route::get('company/order', 'Api\Company\CompaniesOrdersController@store');

});

Route::group([
    'middleware' => ['auth:driver-api'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('driver/logout', 'Api\Driver\AuthController@logout');
    Route::get('driver/me', 'Api\Driver\AuthController@getAuthUser');
    Route::post('driver/token', 'Api\Driver\AuthController@get_fcm_token');
});


