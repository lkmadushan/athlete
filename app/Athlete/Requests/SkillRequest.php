<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class SkillRequest extends FormValidator {

	protected $rules = [
		'name' => 'required|sometimes',
		'notes' => 'required|sometimes',
		'level' => 'required|sometimes'
	];

	public function validateJson($skills)
	{
		foreach($skills as $skill) {

			$this->validate($skill);
		}

		return true;
	}
}