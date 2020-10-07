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

Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function() {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');

    ## Language Route ##
    Route::resource('/languages', 'LanguageController');
    ## End Language Route ##

    ## Main Categories Route ##
    Route::get('/main_categories/change_status/{id}', 'MainCategoryController@change_status')->name('main_categories.status');
    Route::resource('/main_categories', 'MainCategoryController')->except('show');
    ## End Main Categories Route ##

    ## Main Vendors Route ##
    Route::get('/vendors/change_status/{id}', 'VendorController@change_status')->name('vendors.status');
    Route::resource('/vendors', 'VendorController')->except('show');
    ## End Main Categories Route ##

});

Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function() {
    Route::get('/login', 'LoginController@getLogin')->name('admin.login_form');
    Route::post('/login', 'LoginController@login')->name('admin.login');
});

