<?php namespace Athlete\Transformers;

use League\Fractal\TransformerAbstract;
use Video;

class VideoTransformer extends TransformerAbstract
{

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
            'url' => route('video_path', [$video->id, $video->slug]),
            'thumbnail' => route('video_thumb_path', [$video->id, $video->thumbnail]),
            'uploaded_at' => $video->updated_at->format('d M Y'),
        ];
    }
}
