<?php namespace Athlete\Repositories\Team;

use Athlete\Repositories\EloquentRepository;
use Team;

class EloquentTeamRepository extends EloquentRepository implements TeamRepository
{

    /**
     * @param Team $model
     */
    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    /**
     * Filter teams by sport id
     *
     * @param $sportId
     * @return mixed
     */
    public function filterBySport($sportId)
    {
        $this->builder = $this->model->where('sport_id', $sportId)->orderBy('name');

        return $this;
    }
}
