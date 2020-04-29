<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Auth\LoginController@login');

# Attaching auth middleware to API post route and specifiying guard as auth:api
# https://laravel.com/docs/7.x/authentication#adding-custom-user-providers
Route::post('/', 'ReadingController@store')->middleware('auth:api');
