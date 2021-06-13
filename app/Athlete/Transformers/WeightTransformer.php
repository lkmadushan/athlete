<?php namespace Athlete\Transformers;

use League\Fractal\TransformerAbstract;
use Weight;

class WeightTransformer extends TransformerAbstract
{

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
