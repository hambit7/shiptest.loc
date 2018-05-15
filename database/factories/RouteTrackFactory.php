<?php

use Faker\Generator as Faker;

$factory->define(\App\RouteTrack::class, function (Faker $faker) {
    return [
        'route_id' => $faker->numberBetween(1,1000),

        'track_id' =>  factory(\App\Track::class)->create()->id

    ];
});
