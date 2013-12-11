<?php

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            User::create([
                'name'               => $faker->name,
                'email'              => $faker->email,
                'active'             => $i === 0 ? true : rand(0, 1),
                'gender'             => rand(0, 1) ? 'male' : 'female',
                'birthday'           => $faker->dateTimeBetween('-40 years', '-18 years'),
                'location'           => "{$faker->city}, {$faker->state}",
                'bio'                => $faker->sentence(100),
            ]);
        }
    }

}