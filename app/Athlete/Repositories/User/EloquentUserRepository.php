<?php namespace Athlete\Repositories\User;

use User;
use Athlete\Repositories\EloquentRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository {

	/**
	 * @var \User $user
	 */
	protected $model;

	/**
	 * @param User $model
	 */
	public function __construct(User $model)
	{
		$this->model = $model;
	}
}