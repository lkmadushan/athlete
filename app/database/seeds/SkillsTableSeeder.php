<?php

use Faker\Factory as Faker;

class SkillsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$players = Player::lists('id');

		foreach(range(1, 10) as $index)
		{
			Skill::create([
				'name' => $faker->word,
				'notes' => $faker->paragraph(2),
				'level' => $faker->randomElement([
					'excellent', 'good', 'average', 'below average', 'poor'
				]),
				'player_id' => $faker->randomElement($players)
			]);
		}
	}

}