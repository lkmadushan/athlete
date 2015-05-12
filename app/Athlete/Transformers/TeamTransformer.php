<?php namespace Athlete\Transformers;

use Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract {

	/**
	 * Avaliable includes to parse
	 *
	 * @var array
	 */
	protected $availableIncludes = [
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
			'team_id' => (int)$team->id,
			'name' => $team->name,
			'teams_count' => \Auth::user()->teams->count()
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