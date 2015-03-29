<?php

/**
 * Password Reset Controllers
 */
Route::get('password/reset', 'RemindersController@getReset');
Route::get('password/reset', 'RemindersController@postReset');

Route::group(['prefix' => 'api/v1', 'before' => 'api.key'], function()
{
	/**
	 * Account Controllers
	 */
	Route::post('accounts/register', 'AccountsController@register');

	Route::post('accounts/reset-password', 'RemindersController@postRemind');

	/**
	 * Check authentication before routing
	 */
	Route::group(['before' => 'auth.once'], function()
	{
		/**
		 * Account Controllers
		 */
		Route::post('accounts/user', 'AccountsController@user');

		Route::patch('accounts/change-passsword', 'AccountsController@changePassword');

		Route::patch('accounts/change-email', 'AccountsController@changeEmail');

		Route::patch('accounts/purchase', 'AccountsController@makePurchase');

		/**
		 * Resources
		 */
		Route::resource('sports', '', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams', '', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players', '', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players.skills', '', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players.videos', '', ['except' => ['create', 'edit']]);
	});
});
