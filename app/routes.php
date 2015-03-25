<?php

Route::group(['prefix' => 'api/v1'], function()
{
	Route::resource('auth-user', 'AuthController', ['only' => 'store']);
});
