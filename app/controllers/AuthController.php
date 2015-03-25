<?php

use Athletes\Transformers\UserTransformer;

class AuthController extends ApiController {

	/**
	 * @var Athletes\Transformers\UserTransformer
	 */
	protected $userTransformer;

	/**
	 * Inject the UserTransformer
	 *
	 * @param Athletes\Transformers\UserTransformer $userTransformer
	 */
	public function __construct(UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}

	public function index()
	{
		$users = User::all();

		return Response::json([
			'data' => $this->userTransformer->transformCollection($users->all())
		], 200);
	}

	public function store()
	{
		$credentials = Input::only('email', 'password');

		if(Auth::once($credentials)) {

			$authToken = Str::random(32);

			$response = [
				'success' => true,
				'data' => [
					'auth_token' => $authToken,
					'user' => $this->userTransformer->transform(Auth::user()),
				],
			];

			return Response::json($response, 200);
		}

		$response = [
			'success' => false,
			'error' => [
				'message' => 'Unauthorized access!'
			],
		];

		return Response::json($response, 401);
	}

	public function destroy($token)
	{
		//
	}
}