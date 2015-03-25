<?php

Route::group(['prefix' => 'api/v1'], function()
{
	Route::get('auth', 'AuthController@index');
	Route::post('auth', 'AuthController@store');
	Route::delete('auth/{authToken}', 'AuthController@destroy');
});
