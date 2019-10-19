<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Vehicle::class, function (Faker $faker) {
    return [
        'driver_id' => function () {
            return factory(App\Driver::class)->create()->id;
        },
        'category_id' => function () {
            return factory(App\VehicleCategory::class)->create()->id;
        },
        'name' => $faker->name,
        'number' => '123-DUB-SA',
        'type' => $faker->word,
        'capacity' => $faker->word,
        'is_verfied' => $faker->boolean,
        'on_trip' => 0,
        'status' => 0,
    ];
});
