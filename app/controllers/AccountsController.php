<?php

use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\UserTransformer;

class AccountsController extends ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * Inject the UserTransformer
	 *
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 */
	public function __construct(Larasponse $fractal)
	{
		$this->fractal = $fractal;
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
}