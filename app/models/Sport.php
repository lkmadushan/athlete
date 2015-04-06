<?php

class Sport extends \Eloquent {

	protected $fillable = ['name', 'mime'];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function teams()
	{
		return $this->hasMany('Team');
	}

	/**
	 * Set image name when creating a sport
	 *
	 */
	public static function boot()
	{
		parent::boot();

		static::creating(function($model)
		{
			$model->image = Str::random();
		});

		static::updating(function($model)
		{
			$model->image = Str::random();
		});
	}
}