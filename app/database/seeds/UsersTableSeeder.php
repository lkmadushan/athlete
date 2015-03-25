<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 20) as $index)
		{
			User::create([
				'email' => $faker->unique()->email,
				'password' => 'kalpa123'
			]);
		}
	}
}