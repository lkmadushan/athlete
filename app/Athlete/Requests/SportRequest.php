<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class SportRequest extends FormValidator {

	protected $rules = [
		'name' => 'required',
		'image' => 'required|sometimes|mimes:jpeg,bmp,png',
		'mime' => 'required|sometimes|in:image/jpeg,image/png,image/bmp'
	];

	public function updateRules()
	{
		$this->rules = [
			'name' => 'required|sometimes',
			'image' => 'required|sometimes|mimes:jpeg,bmp,png',
			'mime' => 'required|sometimes|in:image/jpeg,image/png,image/bmp'
		];

		return $this;
	}
}