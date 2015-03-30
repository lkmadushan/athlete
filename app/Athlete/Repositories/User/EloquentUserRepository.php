<?php namespace Athlete\Repositories\User;

use User;
use Device;
use Athlete\Repositories\EloquentRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository {

	/**
	 * @param User $model
	 */
	public function __construct(User $model)
	{
		$this->model = $model;
	}

	/**
	 * Save user and device
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function saveWithDevice(array $data)
	{
		return $this->model->create($data)
			->devices()
			->save(new Device($this->parseDeviceInformation($data)));
	}

	/**
	 * Get device information from data array
	 *
	 * @param array $data
	 * @return array
	 */
	public function parseDeviceInformation(array $data)
	{
		return [
			'id' => $data['device_id'],
			'type' => $data['device_type']
		];
	}
}