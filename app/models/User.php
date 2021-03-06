<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class User extends Eloquent implements UserInterface, RemindableInterface
{

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
     * User has many teams through sports
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function teams()
    {
        return $this->hasManyThrough('Team', 'Sport');
    }

    /**
     * User has one device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function device()
    {
        return $this->hasOne('Device');
    }
}
