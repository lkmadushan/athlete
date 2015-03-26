<?php

Route::group(['prefix' => 'api/v1'], function()
{
	Route::post('auth/user', 'AuthController@store');
});
