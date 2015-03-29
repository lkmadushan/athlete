<?php namespace Athlete\Repositories\Sport;

interface SportRepository {

	/**
	 * Filter sports by user id
	 *
	 * @param $userId
	 * @return mixed
	 */
	public function filterByUser($userId);

	public function findById($id);

	public function paginate($limit);
}