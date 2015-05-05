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

		Route::resource('sports.teams.players.skills', 'SkillsController', ['except' => ['create', 'edit']]);

		Route::resource('sports.teams.players.videos', 'VideosController', ['except' => ['create', 'edit']]);
	});
});

/**
 * Image response
 */
Route::get('images/{sportId}/{imageName}', [
	'as' => 'sport_image_path',
	'uses' => 'ImagesController@getSportImage'
]);

Route::get('players/{playerId}/{imageName}', [
	'as' => 'player_image_path',
	'uses' => 'ImagesController@getPlayerImage'
]);

/**
 * Video response
 */
Route::get('videos/{videoId}/{slug}', [
	'as' => 'video_path',
	'uses' => 'VideosController@showVideo'
]);

Route::get('videos/{videoId}/thumbs/{thumbnail}', [
	'as' => 'video_thumb_path',
	'uses' => 'VideosController@showThumbnail'
]);
