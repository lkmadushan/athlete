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
		$this->beforeFilter('auth.once');

		$this->userTransformer = $userTransformer;
	}

	/**
	 * Authenticate user response
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store()
	{
		return Response::json([
			'success' => true,
			'data' => [
				'user' => $this->userTransformer->transform(Auth::user()),
			],
		], 200);
	}
}