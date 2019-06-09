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

        // admin routes
        Route::group(['middleware' => ['role:admin']], function () {
            Route::resource('companies', 'Companies\CompaniesController');
            Route::get('/companies/{company}/ban', 'Companies\CompaniesController@ban')
                ->name('companies.ban');
            Route::get('/companies/{company}/unban', 'Companies\CompaniesController@unban')
                ->name('companies.unban');
            Route::get('/companies/{company}/add_list', 'Companies\CompaniesController@create_list')
                ->name('companies.create_list');
            Route::post('/contacts', 'Companies\CompaniesController@store_list')
                ->name('companies.store_list');
            Route::get('/companies/{company}/contacts', 'Companies\CompaniesController@show')->name('contacts.show');

            Route::get('/companies/{company}/orders', 'Companies\CompaniesController@company_orders');


            Route::get('/users/{user}/ban', 'Users\UsersController@ban')
                ->name('users.ban');
            Route::get('/users/{user}/unban', 'Users\UsersController@unban')
                ->name('users.unban');


            Route::resource('users', 'Users\UsersController');

            Route::resource('orders', 'Orders\OrdersController');
            
            Route::get('supervisors/excel', 'Users\UsersController@export')->name('supervisors.excel');
            #---------- for datatable ----------------------
            Route::get('supervisors_list', 'Users\UsersController@supervisors_List');
            Route::get('get_companies', 'Companies\CompaniesController@get_companies')->name('get.companies');
        });
        // admin|supervisor routes
        Route::group(['middleware' => ['role:admin|supervisor']], function () {
            Route::resource('drivers', 'Drivers\DriversController');
            Route::get('/drivers/{driver}/ban', 'Drivers\DriversController@ban')
                ->name('users.ban');
            Route::get('/drivers/{driver}/unban', 'Drivers\DriversController@unban')
                ->name('users.unban');

            #---------- for datatable ----------------------
            Route::get('get_drivers', 'Drivers\DriversController@get_drivers')->name('get.drivers');
        });

        // Route::get('locked', function () {
        //     Auth::logout();
        //     return view('lockscreen');
        // });

    });
});
