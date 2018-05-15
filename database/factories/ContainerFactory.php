<?php

use Faker\Generator as Faker;

$factory->define(App\Container::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomNumber(),
        'status' => $faker->numberBetween(0,2)
    ];
});
