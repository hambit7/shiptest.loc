<?php

use Faker\Generator as Faker;

$factory->define(App\Route::class, function (Faker $faker) {
    return [
        'total_time' => $faker->time($format = 'H:i') ,
        'total_distance' => $faker->numberBetween(300,1000),
        'average_speed' => $faker->numberBetween(40,120)
    ];
});
