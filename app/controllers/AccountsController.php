<?php

use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\UserTransformer;

class AccountsController extends ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * Includes relations
	 *
	 * @var array
	 */
	private $includes = [
		'sports.teams.players.skills',
		'sports.teams.players.videos',
		'sports.teams.players.heights',
		'sports.teams.players.weights'
	];

	/**
	 * Inject the UserTransformer
	 *
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 */
	public function __construct(Larasponse $fractal)
	{
		$this->fractal = $fractal;

		$this->fractal->parseIncludes($this->getIncludes());
	}

	/**
	 * Get authenticate user response
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function user()
	{
		$data = $this->fractal->item(Auth::user(), new UserTransformer);

		return $this->respondWithSuccess($data);
	}

	/**
	 * Parse includes to comma seperated values
	 *
	 * @return string
	 */
	public function getIncludes()
	{
		return implode(',', $this->includes);
	}
}