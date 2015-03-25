<?php namespace Athlete\Transformers;

abstract class Transformer {

	/**
	 * Transform a collection
	 *
	 * @param $items
	 * @return array
	 */
	public function transformCollection(array $items)
	{
		return array_map([$this, 'transform'], $items);
	}

	/**
	 * Transform an item
	 *
	 * @param $item
	 * @return mixed
	 */
	public abstract function transform($item);
}