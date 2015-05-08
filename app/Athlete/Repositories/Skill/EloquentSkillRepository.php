<?php namespace Athlete\Repositories\Skill;

use Skill;
use Player;
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

	/**
	 * Update an array of skills at once belongs to a player
	 *
	 * @param array $skills
	 * @param Player $player
	 * @return mixed
	 */
	public function updatePlayerSkills(array $skills, Player $player)
	{
		$instances = [];

		foreach($skills as $data)
		{
			$skill = $player->skills()->firstOrNew([
				'id' => $data['skill_id']
			]);

			$skill->fill($data)->save();

			$instances[] = $skill;
		}

		return $instances;
	}
}