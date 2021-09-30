<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Contact::class, function (Faker $faker) {
    return [
        'hubspot_id' => $faker->randomNumber(3),
        'firstname' => $faker->name,
        'lastname' => $faker->lastName,
        'email' => $faker->email
    ];
});
