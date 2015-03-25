<?php namespace Athlete\Filters;

use Illuminate\Auth\AuthManager;

class VerifyAuthentication {

	/**
	 * @var Illuminate\Auth\AuthManager $guard
	 */
	protected $auth;

	public function __construct(AuthManager $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Authenticate the user
	 */
	public function filter()
	{
		$this->auth->onceBasic();

		if($this->auth->guest()) throw new UnauthorizedUserException;
	}
}