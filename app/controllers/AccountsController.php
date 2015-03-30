<?php

use Athlete\Requests\AccountUpdateRequest;
use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\UserTransformer;
use Athlete\Requests\RegisterUserRequest;
use Athlete\Repositories\User\UserRepository;
use Symfony\Component\Security\Core\Util\StringUtils;

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
	 * @var \Athlete\Requests\AccountUpdateRequest $updateRequest
	 */
	private $updateRequest;

	/**
	 * Inject the dependancies
	 *
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param RegisterUserRequest $registerUserRequest
	 * @param \Athlete\Requests\AccountUpdateRequest $updateRequest
	 * @param \Athlete\Repositories\User\UserRepository $repository
	 */
	public function __construct(Larasponse $fractal,
	                            RegisterUserRequest $registerUserRequest,
	                            AccountUpdateRequest $updateRequest,
	                            UserRepository $repository
	)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->registerUserRequest = $registerUserRequest;
		$this->repository = $repository;
		$this->updateRequest = $updateRequest;
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
	 * Register a new user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Laracasts\Validation\FormValidationException
	 */
	public function register()
	{
		$formData = Input::all();

		$this->registerUserRequest->validate($formData);

		$this->repository->saveWithDevice($formData);

		return $this->respondWithSuccess('User has been successfully registered.');
	}

	/**
	 * Change user's password
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Laracasts\Validation\FormValidationException
	 */
	public function changePassword()
	{
		$formData = Input::all();

		$this->updateRequest->changePassword()->validate($formData);

		if(Hash::check($formData['current_password'], Auth::user()->password)) {

			Auth::user()->update($formData);

			return $this->respondWithSuccess('Password has been successfully changed.');
		}

		return $this->respondUnprocess('Cannot change the password!');
	}

	/**
	 * Change user's email
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Laracasts\Validation\FormValidationException
	 */
	public function changeEmail()
	{
		$formData = Input::all();

		$this->updateRequest->changeEmail(Auth::user()->id)->validate($formData);

		if(StringUtils::equals(Auth::user()->email, $formData['current_email'])) {

			Auth::user()->update($formData);

			return $this->respondWithSuccess('Email has been successfully changed.');
		}

		return $this->respondUnprocess('Cannot change the e-mail!');
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