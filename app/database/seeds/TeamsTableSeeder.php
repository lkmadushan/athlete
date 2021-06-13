<?php

use Faker\Factory as Faker;

class TeamsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        $sports = Sport::lists('id');

        foreach (range(1, 10) as $index) {
            Team::create([
                'name' => $faker->word,
                'sport_id' => $faker->randomElement($sports)
            ]);
        }
    }

}
