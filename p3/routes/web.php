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

# Welcome page
Route::get('/', 'PageController@welcome');

/*
* Readings
*/
Route::group(['middleware' => 'auth'], function () {
    # Get paginate variables from post request
    Route::post('/readings/{slug?}', 'ReadingController@show');

    # Show readings for a device
    Route::get('/readings/{slug?}', 'ReadingController@show');
});

/*
* Devices
*/
Route::group(['middleware' => 'auth'], function () {
    # Create a device
    Route::get('/devices/create', 'DeviceController@create');
    Route::post('/devices', 'DeviceController@store');
    
    # Query database for all devices
    Route::get('/devices', 'DeviceController@index');

    # Show a device
    Route::get('/devices/{slug?}', 'DeviceController@show');

    # Update a device
    Route::get('/devices/{slug}/edit', 'DeviceController@edit');
    Route::put('/devices/{slug?}/', 'DeviceController@update');

    # Delete device confirmation page
    Route::get('/devices/{slug}/delete', 'DeviceController@delete');
    # Delete device
    Route::delete('/devices/{slug}', 'DeviceController@destroy');
});

# Auth routes
Auth::routes();
