<?php

use Illuminate\Database\Seeder;

class VehicleCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\VehicleCategory', 10)->create();
    }
}
