<?php namespace Athlete\Transformers;

use League\Fractal\TransformerAbstract;
use Sport;

class SportTransformer extends TransformerAbstract
{

    /**
     * Avaliable includes to parse
     *
     * @var array
     */
    protected $availableIncludes = [
        'teams'
    ];

    /**
     * Transform sport
     *
     * @param \Sport $sport
     * @return array
     */
    public function transform(Sport $sport)
    {
        return [
            'sport_id' => (int)$sport->id,
            'name' => $sport->name,
            'image' => route('sport_image_path', [$sport->id, $sport->image]),
            'image_type' => $sport->image_type,
        ];
    }

    /**
     * Include teams
     *
     * @param \Sport $sport
     * @return \League\Fractal\Resource\Item
     */
    public function includeTeams(Sport $sport)
    {
        $teams = $sport->teams;

        return $this->collection($teams, new TeamTransformer);
    }
}
