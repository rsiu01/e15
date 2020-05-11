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

Route::get('/', 'PageController@welcome');


Route::get('/debug', function () {
    $debug = [
        'Environment' => App::environment(),
    ];

    /*
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    */
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});



/*
* Readings
*/
Route::group(['middleware' => 'auth'], function () {
    # Create a device
    #Route::get('/devices/create', 'DeviceController@create');
    Route::post('/readings/{slug?}', 'ReadingController@show');
    
    
    # Query database for all readings
    Route::get('/readings', 'ReadingController@index');

    # Show readings for a device
    Route::get('/readings/{slug?}', 'ReadingController@show');


    # Update a device
    #Route::get('/devices/{slug}/edit', 'DeviceController@edit');
    #Route::put('/devices/{slug}', 'DeviceController@update');

    # Delete device confirmation page
    #Route::get('/devices/{slug}/delete', 'DeviceController@delete');
    # Delete device
    #Route::delete('/devices/{slug}', 'DeviceController@destroy');
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
    Route::put('/devices/{slug}', 'DeviceController@update');

    # Delete device confirmation page
    Route::get('/devices/{slug}/delete', 'DeviceController@delete');
    # Delete device
    Route::delete('/devices/{slug}', 'DeviceController@destroy');
});

Auth::routes();
