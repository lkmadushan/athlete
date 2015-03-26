<?php

class Height extends \Eloquent {

	protected $fillable = [];

	public function player()
	{
		return $this->belongsTo('Player', 'id', 'id');
	}
}