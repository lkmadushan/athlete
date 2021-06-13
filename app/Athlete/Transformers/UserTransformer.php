<?php namespace Athlete\Transformers;

use League\Fractal\TransformerAbstract;
use User;

class UserTransformer extends TransformerAbstract
{

    /**
     * Avaliable includes to parse
     *
     * @var array
     */
    protected $availableIncludes = [
        'sports'
    ];

    /**
     * Transform user
     *
     * @param $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'token' => $user->device->access_token,
            'user_id' => (int)$user->id,
            'email' => $user->email,
            'is_purchased' => (boolean)$user->is_purchased
        ];
    }

    /**
     * Include sports
     *
     * @param \User $user
     * @return \League\Fractal\Resource\Item
     */
    public function includeSports(User $user)
    {
        $sports = $user->sports;

        return $this->collection($sports, new SportTransformer);
    }
}
