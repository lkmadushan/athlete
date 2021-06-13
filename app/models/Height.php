<?php

class Height extends \Eloquent
{

    protected $fillable = ['id', 'unit', 'value'];

    public function player()
    {
        return $this->belongsTo('Player', 'id', 'id');
    }
}
