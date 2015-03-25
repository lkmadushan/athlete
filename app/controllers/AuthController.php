<?php

use Athlete\Transformers\UserTransformer;

class AuthController extends ApiController {

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
		parent::__construct();

		$this->userTransformer = $userTransformer;
	}

	/**
	 * Authenticate user response
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store()
	{
		return $this->respondWithSuccess([
			'user' => $this->userTransformer->transform(Auth::user()),
		]);
	}
}