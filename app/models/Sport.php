<?php

class Sport extends \Eloquent {

	protected $fillable = [];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function teams()
	{
		return $this->hasMany('Team');
	}
}