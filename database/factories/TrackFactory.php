<?php

use Faker\Generator as Faker;

$factory->define(\App\Track::class, function (Faker $faker) {
    return [
        'latitude' => $faker->randomFloat(),
        'longitude' => $faker->randomFloat(),
        'speed' => $faker->randomFloat(3,0,70),
        'timestamp' => $faker->time($format = 'H:i'),
    ];
});
