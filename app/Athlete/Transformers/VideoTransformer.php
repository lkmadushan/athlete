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
			'url' => route('video_path', [$video->id, $video->title]),
			'thumbnail' => route('video_thumb_path', [$video->id, $video->thumbnail]),
		];
	}
}