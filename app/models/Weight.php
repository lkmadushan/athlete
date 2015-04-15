<?php

class Weight extends \Eloquent {

	protected $fillable = ['unit', 'value'];

	public function player()
	{
		return $this->belongsTo('Player', 'id', 'id');
	}
}