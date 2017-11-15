<?php
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

#AJAX Request
Route::get('/ajax/places', 'AjaxController@getPlaceDetails');

Route::get('/', 'DashboardController@index');
Route::get('/dashboard', 'DashboardController@index');
