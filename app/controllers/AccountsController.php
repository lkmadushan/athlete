<?php

use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\UserTransformer;
use Athlete\Requests\RegisterUserRequest;
use Athlete\Repositories\User\UserRepository;

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
		'sports.teams.players.height',
		'sports.teams.players.weight'
	];

	/**
	 * @var RegisterUserRequest $registerUserRequest
	 */
	private $registerUserRequest;
	/**
	 * @var \Athlete\Repositories\User\UserRepository
	 */
	private $repository;

	/**
	 * Inject the dependancies
	 *
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param RegisterUserRequest $registerUserRequest
	 * @param \Athlete\Repositories\User\UserRepository $repository
	 */
	public function __construct(Larasponse $fractal,
	                            RegisterUserRequest $registerUserRequest,
	                            UserRepository $repository
	)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->registerUserRequest = $registerUserRequest;
		$this->repository = $repository;
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

	public function register()
	{
		$formData = Input::all();

		$this->registerUserRequest->validate($formData);

		$this->repository->saveWithDevice($formData);

		return $this->respondWithSuccess('User has been successfully registered.');
	}

	/**
	 * Parse includes to comma seperated values
	 *
	 * @return string
	 */
	protected function getIncludes()
	{
		return implode(',', $this->includes);
	}
}