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
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', function(){ return redirect('/');});

Route::get('/', 'IndexController@index');
Route::get('/shipped', 'IndexController@shipped');
Route::get('util/reloadorder', 'IndexController@reloadOrder');
Route::get('util/search', 'IndexController@search');
Route::post('util/addorder', 'IndexController@addorder');
Route::post('util/changeorder', 'IndexController@changeorder');
Route::post('util/ordernotordered', 'IndexController@ordernotordered');

Route::group(['middleware' => 'admin'], function(){
    Route::post('util/finduser', 'AdminController@finduser');
    Route::post('util/adduser', 'AdminController@adduser');
    Route::post('util/saveuser', 'AdminController@saveuser');
    Route::post('util/deleteuser', 'AdminController@deleteuser');
});
Route::group(['middleware' => 'storage'], function(){
    Route::get('/util/reloadstorage', 'StorageController@reloadstorage');
    Route::get('/util/checkneworders', 'StorageController@checkneworders');
    Route::post('/util/changedonecount', 'StorageController@changedonecount');
    Route::post('/util/changetakeplace', 'StorageController@changetakeplace');
    Route::post('/util/changestatus', 'StorageController@changestatus');
});

// scripts
Route::post('/backoffice', 'BackofficeController@backoffice');