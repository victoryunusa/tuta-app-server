<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DriversTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VehicleCategoryTableSeeder::class);
        $this->call(VehiclesTableSeeder::class);
        $this->call(TripsTableSeeder::class);
    }
}
