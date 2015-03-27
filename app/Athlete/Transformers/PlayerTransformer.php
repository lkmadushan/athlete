<?php namespace Athlete\Transformers;

use Player;
use League\Fractal\TransformerAbstract;

class PlayerTransformer extends  TransformerAbstract {

	protected $defaultIncludes = [
		'skills', 'videos', 'weights', 'heights'
	];

	/**
	 * Transform player
	 *
	 * @param \Player $player
	 * @return array
	 */
	public function transform(Player $player)
	{
		return [
			'player_id' => $player->id,
			'first_name' => $player->first_name,
			'last_name' => $player->last_name,
			'notes' => $player->notes,
			'born_on' => $player->born_on,
		];
	}

	/**
	 * Include skills
	 *
	 * @param \Player $player
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeSkills(Player $player)
	{
		$skills = $player->skills;

		return $this->collection($skills, new SkillTransformer);
	}

	/**
	 * Include videos
	 *
	 * @param \Player $player
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeVideos(Player $player)
	{
		$videos = $player->videos;

		return $this->collection($videos, new VideoTransformer);
	}

	/**
	 * Include weights
	 *
	 * @param \Player $player
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeWeights(Player $player)
	{
		$weights = $player->weights;

		return $this->collection($weights, new WeightTransformer);
	}

	/**
	 * Include heights
	 *
	 * @param \Player $player
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeHeights(Player $player)
	{
		$heights = $player->heights;

		return $this->collection($heights, new HeightTransformer);
	}
}