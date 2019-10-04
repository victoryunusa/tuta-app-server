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
        'from' => $faker->word,
        'to' => $faker->word,
        'price' => 23.6,
        'start' => $faker->dateTime(),
        'end' => $faker->dateTime(),
    ];
});
