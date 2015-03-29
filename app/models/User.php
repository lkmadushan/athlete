<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $fillable = ['email', 'password'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Hash the password attribute
	 *
	 * @param $value
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	/**
	 * User has many sports
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sports()
	{
		return $this->hasMany('Sport');
	}

	/**
	 * User has many devices
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function devices()
	{
		return $this->hasMany('Device');
	}

	/**
	 * Check user has device
	 *
	 * @param $deviceId
	 * @return bool
	 */
	public function hasDevice($deviceId)
	{
		return in_array($deviceId, $this->devices->lists('id'));
	}
}
