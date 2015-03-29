<?php namespace Athlete\Repositories\Sport;

use Athlete\Repositories\EloquentRepository;
use Sport;

class EloquentSportRepository extends EloquentRepository implements SportRepository {

	/**
	 * @param \Sport $model
	 */
	public function __construct(Sport $model)
	{
		$this->model = $model;
	}

	/**
	 * Filter sports by user id
	 *
	 * @param $userId
	 * @return mixed
	 */
	public function filterByUser($userId)
	{
		$this->builder = $this->model->where('user_id', $userId);

		return $this;
	}
}