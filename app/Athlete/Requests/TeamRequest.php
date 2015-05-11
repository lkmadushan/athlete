<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class TeamRequest extends FormValidator {

	protected $rules = [];

	public function rules($sportId)
	{
		$this->rules = [
			'name' => "required|unique:teams,name,null,id,sport_id,{$sportId}"
		];

		return $this;
	}
}