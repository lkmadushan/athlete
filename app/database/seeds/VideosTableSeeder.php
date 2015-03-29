<?php

use Faker\Factory as Faker;

class VideosTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$players = Player::lists('id');

		foreach(range(1, 10) as $index)
		{
			Video::create([
				'title' => $faker->word,
				'thumbnail' => $faker->word,
				'player_id' => $faker->randomElement($players)
			]);
		}
	}

}