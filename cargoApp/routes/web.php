<?php
use Carbon\Traits\Rounding;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'active'], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        // Route::get('locked', function () {
        //     Auth::logout();
        //     return view('lockscreen');
        // });
    });
});

Route::resource('companies', 'Companies\CompaniesController');
Route::get('/companies/{company}/ban', 'Companies\CompaniesController@ban')
    ->name('companies.ban');
Route::get('/companies/{company}/unban', 'Companies\CompaniesController@unban')
    ->name('companies.unban');

Route::get('/users/{user}/ban', 'Users\UsersController@ban')
    ->name('users.ban');
Route::get('/users/{user}/unban', 'Users\UsersController@unban')
    ->name('users.unban');
Route::resource('users', 'Users\UsersController');

#---------- for datatable ----------------------
Route::get('supervisors_list', 'Users\UsersController@supervisors_List');
Route::get('get_companies', 'Companies\CompaniesController@get_companies')->name('get.companies');
// Route::get('users/{user}', 'Users\UsersController@drivers_list');

