<?php namespace Athlete\Transformers;

use Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'players'
	];

	/**
	 * Transform team
	 *
	 * @param \Team $team
	 * @return array
	 */
	public function transform(Team $team)
	{
		return [
			'team_id' => $team->id,
			'name' => $team->name
		];
	}

	/**
	 * Include players
	 *
	 * @param \Team $team
	 * @return \League\Fractal\Resource\Item
	 */
	public function includePlayers(Team $team)
	{
		$players = $team->players;

		return $this->collection($players, new PlayerTransformer);
	}
}