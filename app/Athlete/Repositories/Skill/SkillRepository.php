<?php namespace Athlete\Repositories\Skill;

interface SkillRepository {

	/**
	 * Filter skills by player id
	 *
	 * @param $playerId
	 * @return mixed
	 */
	public function filterByPlayer($playerId);

	/**
	 * Find skill by id
	 *
	 * @param $id
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * Paginate skills
	 *
	 * @param $limit
	 * @param $offset
	 * @return mixed
	 */
	public function paginate($limit, $offset);

	/**
	 * Save a skill
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function save(array $data);

	/**
	 * Update an array of skills at once belongs to a player
	 *
	 * @param array $skills
	 * @param \Player $player
	 * @return mixed
	 */
	public function updatePlayerSkills(array $skills, \Player $player);
}