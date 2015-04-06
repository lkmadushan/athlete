<?php

/**
 * Password Reset Controllers
 */
Route::get('password/reset/{token}', 'RemindersController@getReset');
Route::post('password/reset', 'RemindersController@postReset');

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
	Route::group(['before' => 'auth'], function()
	{
		/**
		 * Account Controllers
		 */
		Route::post('accounts/user', 'AccountsController@user');

		Route::patch('accounts/change-password', 'AccountsController@changePassword');

		Route::patch('accounts/change-email', 'AccountsController@changeEmail');

		Route::patch('accounts/purchase', 'AccountsController@makePurchase');

		/**
		 * Resources
		 */
		Route::resource('sports', 'SportsController', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams', 'TeamsController', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players', 'PlayersController', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players.skills', '', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players.videos', '', ['except' => ['create', 'edit']]);
	});
});

/**
 * Image response
 */
Route::get('images/{sportId}/{imageName}', [
	'as' => 'image_path',
	'uses' => 'ImagesController@show'
]);

/**
 * Video response
 */
Route::get('videos/{videoId}/{thumbnail}', [
	'as' => 'video_path',
	'uses' => 'VideosController@show'
]);

Route::get('videos/thumbs/{videoId}/{thumbnail}', [
	'as' => 'video_thumb_path',
	'uses' => 'VideosController@showThumbnail'
]);
