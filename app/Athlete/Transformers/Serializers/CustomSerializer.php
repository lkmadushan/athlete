<?php namespace Athlete\Transformers\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class CustomSerializer extends ArraySerializer {

	public function collection($resourceKey, array $data)
	{
		return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
	}

	public function item($resourceKey, array $data)
	{
		return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
	}
}