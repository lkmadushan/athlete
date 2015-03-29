<?php namespace Athlete\Transformers\Serializers;

use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Pagination\PaginatorInterface;

class CustomSerializer extends ArraySerializer {

	/**
	 * Serialize a collection
	 *
	 * @param  string  $resourceKey
	 * @param  array  $data
	 * @return array
	 **/
	public function collection($resourceKey, array $data)
	{
		return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
	}

	/**
	 * Serialize an item
	 *
	 * @param  string  $resourceKey
	 * @param  array  $data
	 * @return array
	 **/
	public function item($resourceKey, array $data)
	{
		return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
	}
}