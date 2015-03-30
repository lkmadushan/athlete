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
	 *
	 * @param $route
	 * @param $request
	 * @throws \Athlete\Filters\UnauthorizedUserException
	 */
	public function filter($route, $request)
	{
		$this->auth->onceBasic();

		if(! $this->authDeviceMatch($request)) $this->resetDevice($request);

		if($this->auth->guest() || ! $this->authDeviceMatch($request)) throw new UnauthorizedUserException;
	}

	/**
	 * Check user has the authenticated device
	 *
	 * @param $request
	 * @return mixed
	 */
	public function authDeviceMatch($request)
	{
		$deviceId = $request->header('X-Auth-Device');

		if($this->auth->check()) return $this->auth->user()->hasDevice($deviceId);
	}

	/**
	 * Reset login device
	 *
	 * @param $request
	 * @return bool
	 */
	public function resetDevice($request)
	{
		if($this->auth->check()) {

			return $this->auth->user()->devices()->update([
				'id' => $request->header('X-Auth-Device'),
				'type' => $request->header('X-Auth-Device-Type'),
				'push_token' => $request->header('X-Auth-Device-Push'),
			]);
		}

		return false;
	}
}