<?php namespace Athlete\Repositories\Player;

use Athlete\Repositories\EloquentRepository;
use Player;

class EloquentPlayerRepository extends EloquentRepository implements PlayerRepository
{

    /**
     * @param \Player $model
     */
    public function __construct(Player $model)
    {
        $this->model = $model;
    }

    /**
     * Filter player by team id
     *
     * @param $teamId
     * @return mixed
     */
    public function filterByTeam($teamId)
    {
        $this->builder = $this->model->where('team_id', $teamId)->orderBy('first_name');

        return $this;
    }
}
