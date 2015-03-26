<?php

class Weight extends \Eloquent {

	protected $fillable = [];

	public function player()
	{
		return $this->belongsTo('Player', 'id', 'id');
	}
}