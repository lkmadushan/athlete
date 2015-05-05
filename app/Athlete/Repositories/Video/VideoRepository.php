<?php namespace Athlete\Repositories\Video;

interface VideoRepository {

	/**
	 * Filter videos by player id
	 *
	 * @param $playerId
	 * @return mixed
	 */
	public function filterByPlayer($playerId);

	/**
	 * Find video by id
	 *
	 * @param $id
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * Paginate videos
	 *
	 * @param $limit
	 * @param $offset
	 * @return mixed
	 */
	public function paginate($limit, $offset);

	/**
	 * Save a video
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function save(array $data);
}