<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Trip::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'driver_id' => function () {
            return factory(App\Driver::class)->create()->id;
        },
        'src_lat' => 9.0422796,
        'src_long' => 7.4998734,
        'dest_lat' => 9.0804156,
        'dest_long' => 7.4499857,
        'fare' => 23.6,
        'start' => $faker->dateTime(),
        'end' => $faker->dateTime(),
    ];
});
