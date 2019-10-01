<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Driver::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'phone_verified_at' => $faker->dateTime(),
        'email_verified_at' => $faker->dateTime(),
        'password' => bcrypt($faker->password),
        'is_verfied' => $faker->boolean,
        'is_online' => $faker->boolean,
        'is_available' => $faker->boolean,
        'remember_token' => Str::random(10),
    ];
});
