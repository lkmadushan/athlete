<?php namespace Athlete\Transformers;

use Weight;
use League\Fractal\TransformerAbstract;

class WeightTransformer extends TransformerAbstract {

	/**
	 * Transform weight
	 *
	 * @param \Weight $weight
	 * @return array
	 */
	public function transform(Weight $weight)
	{
		return [
			'unit' => $weight->unit,
			'value' => (float)$weight->value,
		];
	}
}