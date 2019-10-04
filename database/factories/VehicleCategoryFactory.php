<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\VehicleCategory::class, function (Faker $faker) {
    return [
        'category' => $faker->word
    ];
});
