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

		$this->app->bind('Athlete\Repositories\Sport\SportRepository',
			'Athlete\Repositories\Sport\EloquentSportRepository'
		);

		$this->app->bind('Athlete\Repositories\Team\TeamRepository',
			'Athlete\Repositories\Team\EloquentTeamRepository'
		);

		$this->app->bind('Athlete\Repositories\Player\PlayerRepository',
			'Athlete\Repositories\Player\EloquentPlayerRepository'
		);

		$this->app->bind('Athlete\Repositories\Skill\SkillRepository',
			'Athlete\Repositories\Skill\EloquentSkillRepository'
		);

		$this->app->bind('Athlete\Repositories\Video\VideoRepository',
			'Athlete\Repositories\Video\EloquentVideoRepository'
		);

		$this->app->bind('League\Fractal\Serializer\SerializerAbstract',
			'Athlete\Transformers\Serializers\CustomSerializer'
		);
	}
}