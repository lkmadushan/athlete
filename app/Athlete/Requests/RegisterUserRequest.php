<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class RegisterUserRequest extends FormValidator
{

    protected $rules = [
        'device_id' => 'required',
        'device_type' => 'required',
        'email' => 'unique:users|required|email',
        'password' => 'required'
    ];
}
