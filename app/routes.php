<?php

Route::group(['prefix' => 'api/v1'], function()
{
	/**
	 * Account Controllers
	 */
	Route::post('accounts/register', 'AccountsController@register');

	Route::post('accounts/reset-password', 'AccountsController@resetPassword');

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

Route::get('sandbox', function()
{
	//return Height::find(4)->player->team;

	return User::with('sports.teams.players')
		->with('sports.teams.players.skills')
		->with('sports.teams.players.videos')
		->with('sports.teams.players.weights')
		->with('sports.teams.players.heights')
		->get()->toArray();
});

App::bind('League\Fractal\Serializer\SerializerAbstract', 'Athlete\Transformers\Serializers\CustomSerializer');
