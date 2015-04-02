<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class TeamRequest extends FormValidator {

	protected $rules = [
		'name' => 'required|unique:teams'
	];
}