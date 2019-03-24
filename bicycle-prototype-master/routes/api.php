<?php


Route::get('/', 'BikeController@get_home_api');

Route::get('/bikes/{bike_id}', 'BikeController@get_home_api');
