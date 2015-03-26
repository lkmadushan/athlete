<?php

use Faker\Factory as Faker;

class PlayersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$teams = Team::lists('id');

		foreach(range(1, 10) as $index)
		{
			Player::create([
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'notes' => $faker->paragraph(2),
				'born_on' => $faker->dateTime,
				'team_id' => $faker->randomElement($teams)
			]);
		}
	}

}