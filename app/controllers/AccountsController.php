<?php

use Athlete\Transformers\UserTransformer;

class AccountsController extends ApiController {

	/**
	 * @var Athlete\Transformers\UserTransformer
	 */
	protected $userTransformer;

	/**
	 * Inject the UserTransformer
	 *
	 * @param Athlete\Transformers\UserTransformer $userTransformer
	 */
	public function __construct(UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}

	/**
	 * Get authenticate user response
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function user()
	{
		return $this->respondWithSuccess($this->userTransformer->transform(Auth::user()));
	}
}