<?php namespace Athlete\Transformers;

use League\Fractal\TransformerAbstract;
use Player;

class PlayerTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'weight', 'height'
    ];

    /**
     * Avaliable includes to parse
     *
     * @var array
     */
    protected $availableIncludes = [
        'skills', 'videos', 'weight', 'height'
    ];

    /**
     * Transform player
     *
     * @param \Player $player
     * @return array
     */
    public function transform(Player $player)
    {
        return [
            'player_id' => (int)$player->id,
            'first_name' => $player->first_name,
            'last_name' => $player->last_name,
            'image' => route('player_image_path', [$player->id, $player->image]),
            'notes' => $player->notes,
            'born_on' => $player->born_on,
        ];
    }

    /**
     * Include skills
     *
     * @param \Player $player
     * @return \League\Fractal\Resource\Item
     */
    public function includeSkills(Player $player)
    {
        $skills = $player->skills;

        return $this->collection($skills, new SkillTransformer);
    }

    /**
     * Include videos
     *
     * @param \Player $player
     * @return \League\Fractal\Resource\Item
     */
    public function includeVideos(Player $player)
    {
        $videos = $player->videos;

        return $this->collection($videos, new VideoTransformer);
    }

    /**
     * Include weights
     *
     * @param \Player $player
     * @return \League\Fractal\Resource\Item
     */
    public function includeWeight(Player $player)
    {
        $weight = $player->weight;

        if ($weight) return $this->item($weight, new WeightTransformer);
    }

    /**
     * Include heights
     *
     * @param \Player $player
     * @return \League\Fractal\Resource\Item
     */
    public function includeHeight(Player $player)
    {
        $height = $player->height;

        if ($height) return $this->item($height, new HeightTransformer);
    }
}
