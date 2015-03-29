<?php

use Faker\Factory as Faker;

class SportsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$users = User::lists('id');

		foreach(range(1, 100) as $index)
		{
			Sport::create([
				'name' => $faker->word,
				'image' => $faker->word,
				'user_id' => $faker->randomElement($users)
			]);
		}
	}

}