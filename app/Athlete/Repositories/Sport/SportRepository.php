<?php namespace Athlete\Repositories\Sport;

interface SportRepository
{

    /**
     * Filter sports by user id
     *
     * @param $userId
     * @return mixed
     */
    public function filterByUser($userId);

    /**
     * Find sport by id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * Paginate sports
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
