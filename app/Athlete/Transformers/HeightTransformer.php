<?php namespace Athlete\Transformers;

use Height;
use League\Fractal\TransformerAbstract;

class HeightTransformer extends TransformerAbstract {

	/**
	 * Transform height
	 *
	 * @param \Height $height
	 * @return array
	 */
	public function transform(Height $height)
	{
		return [
			'unit' => $height->unit,
			'value' => (float)$height->value
		];
	}
}