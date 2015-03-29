<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class SportRequest extends FormValidator {

	protected $rules = [
		'name' => 'required',
		'image' => 'required|mimes:jpeg,bmp,png'
	];

	public function updateRules()
	{
		$this->rules = [
			'name' => 'required|sometimes',
			'image' => 'mimes:png'
		];

		return $this;
	}
}