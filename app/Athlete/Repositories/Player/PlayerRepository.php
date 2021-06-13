<?php namespace Athlete\Repositories\Player;

interface PlayerRepository
{

    /**
     * Filter players by team id
     *
     * @param $teamId
     * @return mixed
     */
    public function filterByTeam($teamId);

    /**
     * Find sport by id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * Paginate players
     *
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function paginate($limit, $offset);

    /**
     * Save a sport
     *
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
}
