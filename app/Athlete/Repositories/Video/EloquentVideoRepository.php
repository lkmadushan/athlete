<?php namespace Athlete\Repositories\Video;

use Video;
use Athlete\Repositories\EloquentRepository;

class EloquentVideoRepository extends EloquentRepository implements VideoRepository {

	/**
	 * @param Video $model
	 */
	public function __construct(Video $model)
	{
		$this->model = $model;
	}

	/**
	 * Filter videos by player id
	 *
	 * @param $playerId
	 * @return mixed
	 */
	public function filterByPlayer($playerId)
	{
		$this->builder = $this->model->where('player_id', $playerId);

		return $this;
	}
}