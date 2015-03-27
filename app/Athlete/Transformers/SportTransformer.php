<?php namespace Athlete\Transformers;

use Sport;
use League\Fractal\TransformerAbstract;

class SportTransformer extends TransformerAbstract {

	/**
	 * Avaliable includes to parse
	 *
	 * @var array
	 */
	protected $availableIncludes = [
		'teams'
	];

	/**
	 * Transform sport
	 *
	 * @param \Sport $sport
	 * @return array
	 */
	public function transform(Sport $sport)
	{
		return [
			'sport_id' => (int)$sport->id,
			'name' => $sport->name,
			'image' => $sport->image
		];
	}

	/**
	 * Include teams
	 *
	 * @param \Sport $sport
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeTeams(Sport $sport)
	{
		$teams = $sport->teams;

		return $this->collection($teams, new TeamTransformer);
	}
}