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
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('locked', function () {
        Auth::logout();
        return view('lockscreen');
    });
});

// Route::get('/admin/edit','Users\AdminController@edit')->name('admin.edit');
// Route::patch('admin/{admin}','Users\AdminController@update')->name('admin.update');
Route::resource('companies','Companies\CompaniesController');
Route::resource('users','Users\UsersController');

?>