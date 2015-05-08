<?php

class Skill extends \Eloquent {

	protected $fillable = ['name', 'notes', 'level', 'player_id'];

	public function setLevelAttribute($value)
	{
		$this->attributes['level'] = strtolower($value);
	}

	public function getLevelAttribute($value)
	{
		return ucfirst($value);
	}

	public function player()
	{
		return $this->belongsTo('Player');
	}
}