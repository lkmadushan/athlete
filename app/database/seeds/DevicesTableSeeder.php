<?php

use Faker\Factory as Faker;

class DevicesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$users = User::lists('id');

		foreach(range(1, 10) as $index)
		{
			Device::create([
				'id' => $faker->unique()->uuid,
				'type' => 'apple',
				'push_token' => $faker->unique()->uuid,
				'user_id' => $faker->randomElement($users)
			]);
		}
	}

}