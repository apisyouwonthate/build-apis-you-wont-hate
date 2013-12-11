<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $truncate = [
            'checkins',
            'places',
            'users',
        ];

        foreach ($truncate as $table) {
            DB::table($table)->truncate();
        }

        $this->call('UserTableSeeder');
        $this->call('PlaceTableSeeder');
    }

}