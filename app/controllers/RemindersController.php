<?php

class RemindersController extends ApiController {

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		$response = Password::remind(Input::only('email'), function($message)
		{
			$message->subject('Password Reset');
		});

		switch ($response)
		{
			case Password::INVALID_USER:
				return $this->respondUnprocess(Lang::get($response));

			case Password::REMINDER_SENT:
				return $this->respondWithSuccess(Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		Password::validator(function($credentials)
		{
			return strlen($credentials['password']) >= 1;
		});

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = $password;
			$user->save();

			Device::whereUserId($user->id)->update([
				'access_token' => Str::random(64)
			]);
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::back()->with('success', 'Password has been successfully changed.');
		}
	}
}
