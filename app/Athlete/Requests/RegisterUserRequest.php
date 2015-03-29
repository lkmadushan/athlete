<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class RegisterUserRequest extends FormValidator {

	protected $rules = [
		'device_id' => 'unique:devices,id|required',
		'device_type' => 'required',
		'push_token' => 'unique:devices|required',
		'email' => 'unique:users|required|email',
		'password' => 'required'
	];
}