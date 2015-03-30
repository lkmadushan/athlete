<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class AccountUpdateRequest extends FormValidator {

	protected $rules = [];

	public function changePassword()
	{
		$this->rules = [
			'current_password' => 'required',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required'
		];

		return $this;
	}

	public function changeEmail($id)
	{
		$this->rules = [
			'current_email' => 'required',
			'email' => "required|email|unique:users,email,{$id},id|confirmed",
			'email_confirmation' => 'required'
		];

		return $this;
	}
}