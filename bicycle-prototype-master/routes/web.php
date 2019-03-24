<?php

use Illuminate\Support\Facades\Storage as Storage;

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

Route::get('/', 'BikeController@get_home_web');

Route::get('/bikes/{bike_id}', 'BikeController@get_home_web');
