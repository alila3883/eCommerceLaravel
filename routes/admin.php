<?php

use Illuminate\Support\Facades\Route;

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

//define('PAGINATION_COUNT', 10);
Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function() {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');

    ## Language Route ##
    Route::resource('/languages', 'LanguageController');
    ## End Language Route ##

    ## Main Categories Route ##
    Route::resource('/main_categories', 'MainCategoryController')->except('show');
    ## End Main Categories Route ##

    ## Main Vendors Route ##
    Route::resource('/vendors', 'VendorController');
    ## End Main Categories Route ##

});

Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function() {
    Route::get('/login', 'LoginController@getLogin')->name('admin.login_form');
    Route::post('/login', 'LoginController@login')->name('admin.login');
});

