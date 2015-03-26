<?php

class Team extends \Eloquent {

	protected $fillable = [];

	public function sport()
	{
		return $this->belongsTo('Sport');
	}

	public function players()
	{
		return $this->hasMany('Player');
	}
}