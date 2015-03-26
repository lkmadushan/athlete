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

	public function weights()
	{
		return $this->hasMany('Weight', 'id', 'id');
	}

	public function heights()
	{
		return $this->hasMany('Height', 'id', 'id');
	}
}