<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'password' => bcrypt($faker->password),
        'email_verified_at' => $faker->dateTime(),
        'remember_token' => Str::random(10),
        'settings' => $faker->word,
    ];
});
