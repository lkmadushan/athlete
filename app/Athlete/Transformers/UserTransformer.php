<?php namespace Athlete\Transformers;

use User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
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
			'user_id' => $user->id,
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