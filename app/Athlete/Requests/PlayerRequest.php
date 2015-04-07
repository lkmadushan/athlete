<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class PlayerRequest extends FormValidator {

	protected $rules = [
		'first_name' => 'required',
		'last_name' => 'required',
		'image' => 'required|mimes:jpeg,bmp,png',
		'mime' => 'required_with:image|in:image/jpeg,image/png,image/bmp',
		'born_on' => 'required|sometimes',
		'height' => 'required|sometimes',
		'weight' => 'required|sometimes'
	];

	public function updateRules()
	{
		$this->rules = [
			'first_name' => 'required|sometimes',
			'last_name' => 'required|sometimes',
			'image' => 'required|sometimes|mimes:jpeg,bmp,png',
			'mime' => 'required_with:image|in:image/jpeg,image/png,image/bmp',
			'born_on' => 'required|sometimes',
			'height' => 'required|sometimes',
			'weight' => 'required|sometimes',
			'note' => 'required|sometimes'
		];

		return $this;
	}
}