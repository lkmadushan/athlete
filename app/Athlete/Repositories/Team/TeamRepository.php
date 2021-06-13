<?php namespace Athlete\Repositories\Team;

interface TeamRepository
{

    /**
     * Filter teams by sport id
     *
     * @param $sportId
     * @return mixed
     */
    public function filterBySport($sportId);

    /**
     * Find teams by id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * Paginate teams
     *
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function paginate($limit, $offset);

    /**
     * Save a team
     *
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
}
