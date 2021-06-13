<?php

use Faker\Factory as Faker;

class VideosTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        $players = Player::lists('id');

        foreach (range(1, 10) as $index) {
            Video::create([
                'title' => $faker->word,
                'slug' => $faker->word,
                'thumbnail' => $faker->word,
                'thumbnail_mime' => 'image/jpeg',
                'video_mime' => 'video/mp4',
                'player_id' => $faker->randomElement($players)
            ]);
        }
    }

}
