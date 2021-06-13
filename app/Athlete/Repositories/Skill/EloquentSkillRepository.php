<?php namespace Athlete\Repositories\Skill;

use Athlete\Repositories\EloquentRepository;
use Player;
use Skill;

class EloquentSkillRepository extends EloquentRepository implements SkillRepository
{

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
     * Update or insert an array of skills at once belongs to a player
     *
     * @param array $skills
     * @param Player $player
     * @return mixed
     */
    public function updateOrInsertPlayerSkills(array $skills, Player $player)
    {
        $instances = [];

        foreach ($skills as $data) {
            $skill = $this->model->findOrNew($data['skill_id']);
            $skill->fill($data);

            $player->skills()->save($skill);

            $instances[] = $skill;
        }

        return $instances;
    }
}
