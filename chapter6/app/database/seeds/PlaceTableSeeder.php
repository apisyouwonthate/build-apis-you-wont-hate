<?php

use Faker\Factory as Faker;

class PlaceTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $place = Place::create([
                'name'       => $faker->name,
                'lat'        => $faker->latitude,
                'lon'        => $faker->longitude,
                'address1'   => $faker->streetAddress,
                'city'       => $faker->city,
                'state'      => $faker->stateAbbr,
                'zip'        => rand(10000, 30000),
                'website'    => $faker->url,
                'phone'      => $faker->phoneNumber,
            ]);

            foreach (User::all() as $user) {
                if (rand(0, 2) == 1) {
                    $place->checkins()->create(['user_id' => $user->id]);
                }
            }
        }
    }

}