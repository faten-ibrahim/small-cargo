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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('company/login', 'Api\Company\AuthController@login');
// Route::post('company/logout', 'Api\Company\AuthController@logout');
// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {


//     Route::post('company/refresh', 'Api\Company\AuthController@refresh');
//     Route::post('company/me', 'Api\Company\AuthController@me');
// });



Route::post('company/register', 'Api\Company\AuthController@register');
Route::post('company/login', 'Api\Company\AuthController@login');
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('logout', 'Api\Company\AuthController@logout');
    Route::post('refresh', 'Api\Company\AuthController@refresh');
    Route::post('me', 'Api\Company\AuthController@me');

});
