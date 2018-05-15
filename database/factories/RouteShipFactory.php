<?php

use Faker\Generator as Faker;

$factory->define(App\RouteShip::class, function (Faker $faker) {
    return [
        'ship_id' => factory(\App\Ship::class)->create()->id,

        'route_id' => factory(\App\Route::class)->create()->id,

    ];
});
