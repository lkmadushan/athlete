<?php namespace Athlete\Repositories\User;

use Str;
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
			->device()
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
			'type' => $data['device_type'],
			'access_token' => Str::random(64)
		];
	}

	/**
	 * Purchase the account
	 *
	 * @param \User $user
	 * @return bool
	 */
	public function makePurchase(User $user)
	{
		if( ! $user->is_purchased) {
			$user->is_purchased = 1;

			return $user->save();
		}

		return false;
	}
}