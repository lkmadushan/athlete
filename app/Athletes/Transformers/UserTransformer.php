<?php namespace Athletes\Transformers;


class UserTransformer extends Transformer {

	/**
	 * Transform an item
	 *
	 * @param $user
	 * @return array
	 */
	public function transform($user)
	{
		return [
			'user_id' => $user['id'],
			'email' => $user['email']
		];
	}
}