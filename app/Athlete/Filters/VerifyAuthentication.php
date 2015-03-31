<?php namespace Athlete\Filters;

use Str;
use Illuminate\Auth\AuthManager;
use Symfony\Component\Security\Core\Util\StringUtils;

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
		$credentials = $request->only('email', 'password');

		$this->auth->once($credentials);

		if($this->auth->check() && ! $this->authDeviceMatch($request)) $this->resetDevice($request);

		if($this->auth->guest() || ! $this->authDeviceMatch($request)) throw new UnauthorizedUserException;
	}

	/**
	 * Match the authenticated device
	 *
	 * @param $request
	 * @return bool
	 */
	public function authDeviceMatch($request)
	{
		$deviceId = $request->header('X-Auth-Device');

		if($this->auth->check())
			return StringUtils::equals($this->auth->user()->device->id, $deviceId);

		return false;
	}

	/**
	 * Reset the device
	 *
	 * @param $request
	 */
	public function resetDevice($request)
	{
		return $this->auth->user()->device()->update([
			'id' => $request->header('X-Auth-Device'),
			'type' => strtolower($request->header('X-Auth-Device-Type')),
			'access_token' => Str::random(64),
		]);
	}
}