<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class VideoRequest extends FormValidator {

	protected $rules = [
		'title' => 'required',
		'video' => 'required|max:100000',
		'video_mime' => 'required_with:video|in:video/mp4',
		'thumbnail_image' => 'required_with:video|sometimes|mimes:jpeg,bmp,png',
		'thumbnail_mime' => 'required_with:thumbnail_image|in:image/jpeg,image/png,image/bmp',
	];

	public function updateRules()
	{
		$this->rules = [
			'title' => 'required|sometimes',
			'video' => 'required|sometimes|max:100000',
			'video_mime' => 'required_with:video|in:video/mp4',
			'thumbnail_image' => 'required_with:video|sometimes|mimes:jpeg,bmp,png',
			'thumbnail_mime' => 'required_with:thumbnail_image|in:image/jpeg,image/png,image/bmp',
		];

		return $this;
	}
}