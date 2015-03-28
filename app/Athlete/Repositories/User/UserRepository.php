<?php namespace Athlete\Repositories\User;

interface UserRepository {

	/**
	 * Persist a user
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function save(array $data);
}