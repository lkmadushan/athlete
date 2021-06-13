<?php

class Video extends \Eloquent
{

    protected $fillable = ['title', 'slug', 'thumbnail', 'thumbnail_mime', 'video_mime'];

    public function player()
    {
        return $this->belongsTo('Player');
    }
}
