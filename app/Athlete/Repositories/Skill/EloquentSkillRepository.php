<?php namespace Athlete\Repositories\Skill;

use Skill;
use Athlete\Repositories\EloquentRepository;

class EloquentSkillRepository extends EloquentRepository implements SkillRepository {

	/**
	 * @param Skill $model
	 */
	public function __construct(Skill $model)
	{
		$this->model = $model;
	}

	/**
	 * Filter skills by player id
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