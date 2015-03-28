<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class RegisterUserRequest extends FormValidator {

	protected $rules = [
		'email' => 'required|email|unique:users',
		'password' => 'required'
	];
}