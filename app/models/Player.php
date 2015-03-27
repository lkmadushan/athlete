<?php

class Player extends \Eloquent {

	protected $fillable = [];

	public function team()
	{
		return $this->belongsTo('Team');
	}

	public function skills()
	{
		return $this->hasMany('Skill');
	}

	public function videos()
	{
		return $this->hasMany('Video');
	}

	public function weight()
	{
		return $this->hasOne('Weight', 'id', 'id');
	}

	public function height()
	{
		return $this->hasOne('Height', 'id', 'id');
	}
}