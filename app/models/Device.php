<?php

class Device extends \Eloquent {

	protected $fillable = ['id', 'type', 'push_token', 'user_id'];

	public function setTypeAttribute($value)
	{
		$this->attributes['type'] = strtolower($value);
	}

	public function getTypeAttribute($value)
	{
		return strtoupper($value);
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}