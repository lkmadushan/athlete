<?php namespace Athlete\Repositories;

abstract class EloquentRepository {

	/**
	 * @var \User $user
	 */
	protected $model;

	/**
	 * @param User $model
	 */
	public function __construct($model)
	{
		$this->model = $model;
	}

	/**
	 * Persist a model
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function save(array $data)
	{
		return $this->model->create($data);
	}
}