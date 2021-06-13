<?php namespace Athlete\Repositories;

abstract class EloquentRepository
{

    /**
     * @var \User $user
     */
    protected $model;

    /**
     * @var $builder
     */
    protected $builder;

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

    public function findById($id)
    {
        return $this->builder->findOrFail($id);
    }

    public function paginate($limit, $offset)
    {
        return $this->builder->latest()->skip($offset)->take($limit)->get();
    }
}
