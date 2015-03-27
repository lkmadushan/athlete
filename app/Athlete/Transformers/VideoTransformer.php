<?php namespace Athlete\Transformers;

use Video;
use League\Fractal\TransformerAbstract;

class VideoTransformer extends TransformerAbstract {

	/**
	 * Transform video
	 *
	 * @param \Video $video
	 * @return array
	 */
	public function transform(Video $video)
	{
		return [
			'video_id' => (int)$video->id,
			'title' => $video->title,
			'thumbnail' => $video->thumb
		];
	}
}