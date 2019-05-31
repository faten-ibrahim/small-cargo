<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('company/login', 'Api\Company\AuthController@login');
Route::post('company/register', 'Api\Company\AuthController@register');
// Route::group(['middleware' => ['jwt.verify']], function() {
Route::post('company/logout', 'Api\Company\AuthController@logout');
Route::get('company/getAuthUser', 'Api\Company\AuthController@getAuthUser');
// });

Route::post('driver/login', 'Api\Driver\AuthController@login');
Route::post('driver/register', 'Api\Driver\AuthController@register');
Route::post('driver/logout', 'Api\Driver\AuthController@logout');


// Route::group(['middleware' => 'auth.jwt'], function () {

// });

// Route::group([
//     'middleware' => ['auth:driver-api'],
//     'prefix' => 'auth'
// ], function ($router) {
//     Route::post('driver/logout', 'Api\Driver\AuthController@logout');
// });


