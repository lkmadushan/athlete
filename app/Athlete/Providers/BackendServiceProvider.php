<?php namespace Athlete\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Athlete\Repositories\User\UserRepository',
			'Athlete\Repositories\User\EloquentUserRepository'
		);
	}
}