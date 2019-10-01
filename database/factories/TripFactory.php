<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Trip::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'driver_id' => function () {
            return factory(App\Driver::class)->create()->id;
        },
        'from' => $faker->word,
        'to' => $faker->word,
        'price' => $faker->randomFloat(),
        'start' => $faker->dateTime(),
        'end' => $faker->dateTime(),
        'customer_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});
